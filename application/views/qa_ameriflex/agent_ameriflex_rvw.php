<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
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
									<tr>
										<td colspan="6" id="theader" style="font-size:30px">Ameriflex</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($ameriflex_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($ameriflex['entry_by']!=''){
												$auditorName = $ameriflex['auditor_name'];
											}else{
												$auditorName = $ameriflex['client_name'];
											}
											$auditDate = mysql2mmddyy($ameriflex['audit_date']);
											$clDate_val = mysql2mmddyy($ameriflex['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date: <span style="font-size:24px;color:red">*</span></td>
										<td style="width:200px"><input type="text" class="form-control" id="call_date" name="data[call_date]" value="<?php echo $ameriflex['call_date'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
												<?php if($ameriflex['agent_id']){ ?>
												<option value="<?php echo $ameriflex['agent_id'] ?>"><?php echo $ameriflex['fname']." ".$ameriflex['lname'] ?></option>
											   <?php } ?>
												<option value="">--Select--</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Agent ID: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ameriflex['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $ameriflex['tl_id'] ?>"><?php echo $ameriflex['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ameriflex['call_duration'] ?>" disabled ></td>
										<td>Type:</td>
										<td>
											<select class="form-control" id="process_type" name="data[type]" disabled>
												<option value="">-Select-</option>
												<option value="call" <?php echo $ameriflex['type']=='call'?"selected":""; ?>>Call</option>
												<option value="chat" <?php echo $ameriflex['type']=='chat'?"selected":""; ?>>Chat</option>
											</select>
										</td>
										<td>Interaction ID: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $ameriflex['interaction_id']; ?>" name="data[interaction_id]" disabled></td>
									</tr>
									<tr>
										<td>ACPT: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="acpt" name="data[acpt]" disabled>
											<option value="<?php echo $ameriflex['acpt'] ?>"><?php echo $ameriflex['acpt'] ?></option>	
											<option value="">-Select-</option>
											<option <?php echo $ameriflex['acpt']=='Agent'?"selected":""; ?> value="Agent">Agent</option>
											<option <?php echo $ameriflex['acpt']=='Customer'?"selected":""; ?> value="Customer">Customer</option>
											<option <?php echo $ameriflex['acpt']=='Process'?"selected":""; ?> value="Process">Process</option>
											<option <?php echo $ameriflex['acpt']=='Technical'?"selected":""; ?> value="Technical">Technical</option>
											<option <?php echo $ameriflex['acpt']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>VOC: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $ameriflex['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $ameriflex['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $ameriflex['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $ameriflex['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $ameriflex['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										<td>Audit Type: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
											<option value="<?php echo $ameriflex['audit_type'] ?>"><?php echo $ameriflex['audit_type'] ?></option>	
											<option value="">-Select-</option>
											<option <?php echo $ameriflex['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $ameriflex['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $ameriflex['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
											<option <?php echo $ameriflex['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $ameriflex['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											<option value="WOW Call">WOW Call</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type: <span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="<?php echo $ameriflex['auditor_type'] ?>"><?php echo $ameriflex['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="ameriflex_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ameriflex['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="ameriflex_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ameriflex['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="ameriflex_overall_score" name="data[overall_score]" class="form-control gds_prearrival_fatal" style="font-weight:bold" value="<?php echo $ameriflex['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td colspan=3>Parameter</td>
										<td>Rating</td>
										<td colspan=2>Remarks</td>
									</tr>
									<tr><td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Verification and Greeting</td></tr>
									<tr>
										<td class="eml1" colspan=3>Has the caller been properly greeted and verified?</td>
										<td>
											<select class="form-control bsnl_point" name="data[caller_properly_greed]" disabled>
												<option bsnl_val=11 <?php echo $ameriflex['caller_properly_greed'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=11 <?php echo $ameriflex['caller_properly_greed'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['caller_properly_greed'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $ameriflex['cmt1'] ?>"></td>
									</tr>
									<tr><td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Communication Skills</td></tr>
									<tr>
										<td class="eml1" colspan=3>Did we show empathy/sympathy when necessary if applicable?</td>
										<td>
											<select class="form-control bsnl_point " name="data[show_empathy_sympathy]" disabled>
												<option bsnl_val=5 <?php echo $ameriflex['show_empathy_sympathy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=5 <?php echo $ameriflex['show_empathy_sympathy'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['show_empathy_sympathy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $ameriflex['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we adjust to the caller's pace and demeanor? (especially when faced with a difficult situation)</td>
										<td>
											<select class="form-control bsnl_point " name="data[adjust_caller_pace]" disabled>
												<option bsnl_val=6 <?php echo $ameriflex['adjust_caller_pace'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=6 <?php echo $ameriflex['adjust_caller_pace'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['adjust_caller_pace'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $ameriflex['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we use the caller's name two times throughout the call?</td>
										<td>
											<select class="form-control bsnl_point " name="data[use_caller_name_two_times]" disabled>
												<option bsnl_val=6 <?php echo $ameriflex['use_caller_name_two_times'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=6 <?php echo $ameriflex['use_caller_name_two_times'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['use_caller_name_two_times'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $ameriflex['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we sound as though we wanted to assist the caller? Did we use a helpful tone of voice and word choice? Would the participant assess the interaction as polite/courteous?</td>
										<td>
											<select class="form-control bsnl_point " name="data[sound_though_assist_caller]" disabled>
												<option bsnl_val=8 <?php echo $ameriflex['sound_though_assist_caller'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=8 <?php echo $ameriflex['sound_though_assist_caller'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['sound_though_assist_caller'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $ameriflex['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we avoid interruptions and speaking over the caller?</td>
										<td>
											<select class="form-control bsnl_point " name="data[avoid_interruption_caller_speaking]" disabled>
												<option bsnl_val=5 <?php echo $ameriflex['avoid_interruption_caller_speaking'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=5 <?php echo $ameriflex['avoid_interruption_caller_speaking'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['avoid_interruption_caller_speaking'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $ameriflex['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we use thank you's and apologies as appropriate?</td>
										<td>
											<select class="form-control bsnl_point " name="data[use_thatnk_you_appologies]" disabled>
												<option bsnl_val=6 <?php echo $ameriflex['use_thatnk_you_appologies'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=6 <?php echo $ameriflex['use_thatnk_you_appologies'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['use_thatnk_you_appologies'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $ameriflex['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we own the issue ("we" not "they" or other departments)?</td>
										<td>
											<select class="form-control bsnl_point " name="data[own_the_issue]" disabled>
												<option bsnl_val=6 <?php echo $ameriflex['own_the_issue'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=6 <?php echo $ameriflex['own_the_issue'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['own_the_issue'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $ameriflex['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we avoid dead air?</td>
										<td>
											<select class="form-control bsnl_point " name="data[avoid_dead_air]" disabled>
												<option bsnl_val=5 <?php echo $ameriflex['avoid_dead_air'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=5 <?php echo $ameriflex['avoid_dead_air'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['avoid_dead_air'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $ameriflex['cmt9'] ?>"></td>
									</tr>
									<tr><td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Product Knowledge</td></tr>
									<tr>
										<td class="eml1" colspan=3>Did we confirm/update caller's contact information? (phone and/or email)</td>
										<td>
											<select class="form-control bsnl_point" name="data[confirm_caller_contact]" disabled>
												<option bsnl_val=2 <?php echo $ameriflex['confirm_caller_contact'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $ameriflex['confirm_caller_contact'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['confirm_caller_contact'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $ameriflex['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we communicate all appropriate timelines and steps?</td>
										<td>
											<select class="form-control bsnl_point" name="data[communicate_timelines]" disabled>
												<option bsnl_val=2 <?php echo $ameriflex['communicate_timelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $ameriflex['communicate_timelines'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['communicate_timelines'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $ameriflex['cmt11'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we ask appropriate clarifying and probing questions? Did we repeat the caller's question/issue, verify or confirm our understanding?</td>
										<td>
											<select class="form-control bsnl_point" name="data[repeat_caller_question_issue]" disabled>
												<option bsnl_val=3 <?php echo $ameriflex['repeat_caller_question_issue'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=3 <?php echo $ameriflex['repeat_caller_question_issue'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['repeat_caller_question_issue'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $ameriflex['cmt12'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we provide professional, accurate details via call/chat?</td>
										<td>
											<select class="form-control bsnl_point" name="data[provide_professional_accurate]" disabled>
												<option bsnl_val=6 <?php echo $ameriflex['provide_professional_accurate'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=6 <?php echo $ameriflex['provide_professional_accurate'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['provide_professional_accurate'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $ameriflex['cmt13'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we take appropriate actions in Ameriflex Systems?</td>
										<td>
											<select class="form-control bsnl_point" name="data[take_appropiate_actiona]" disabled>
												<option bsnl_val=2 <?php echo $ameriflex['take_appropiate_actiona'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $ameriflex['take_appropiate_actiona'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['take_appropiate_actiona'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $ameriflex['cmt14'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we demonstrate appropriate use of the hold process?</td>
										<td>
											<select class="form-control bsnl_point" name="data[demonstrate_appropiate_hold_process]" disabled>
												<option bsnl_val=3 <?php echo $ameriflex['demonstrate_appropiate_hold_process'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=3 <?php echo $ameriflex['demonstrate_appropiate_hold_process'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['demonstrate_appropiate_hold_process'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $ameriflex['cmt15'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we avoid internal jargon?</td>
										<td>
											<select class="form-control bsnl_point" name="data[avoid_internal_jargon]" disabled>
												<option bsnl_val=3 <?php echo $ameriflex['avoid_internal_jargon'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=3 <?php echo $ameriflex['avoid_internal_jargon'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['avoid_internal_jargon'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $ameriflex['cmt16'] ?>"></td>
									</tr>
									<tr><td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Post Contact Closure</td></tr>
									<tr>
										<td class="eml1" colspan=3>Did we validate if the issue/question was resolved?</td>
										<td>
											<select class="form-control bsnl_point" name="data[validate_issue_was_resolved]" disabled>
												<option bsnl_val=2 <?php echo $ameriflex['validate_issue_was_resolved'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $ameriflex['validate_issue_was_resolved'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['validate_issue_was_resolved'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $ameriflex['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we ask if any additional assistance is needed?</td>
										<td>
											<select class="form-control bsnl_point" name="data[ask_any_additional_assistance]" disabled>
												<option bsnl_val=2 <?php echo $ameriflex['ask_any_additional_assistance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $ameriflex['ask_any_additional_assistance'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['ask_any_additional_assistance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $ameriflex['cmt18'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did we properly close the call?</td>
										<td>
											<select class="form-control bsnl_point" name="data[properly_close_the_call]" disabled>
												<option bsnl_val=2 <?php echo $ameriflex['properly_close_the_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $ameriflex['properly_close_the_call'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $ameriflex['properly_close_the_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $ameriflex['cmt19'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ameriflex['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $ameriflex['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($ameriflex_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($ameriflex['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ameriflex['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ameriflex/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ameriflex/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($ameriflex_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $ameriflex['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $ameriflex['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $ameriflex['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $ameriflex['client_rvw_note'] ?></td></tr>
									<?php } ?>

									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="ameriflex_id" class="form-control" value="<?php echo $ameriflex_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $ameriflex['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $ameriflex['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $ameriflex['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($ameriflex['entry_date'],72) == true){ ?>
											<tr>
												<?php if($ameriflex['agent_rvw_note']==''){ ?>
													<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									  </form>
									
									<?php 
									if($ameriflex_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($ameriflex['entry_date'],72) == true){ ?>
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
				</div>
			</div>
		</div>

	</section>
</div>
