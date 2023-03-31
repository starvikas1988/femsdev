
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
	background-color:#CCD1D1;
}

.eml2{
	font-size:24px;
	font-weight:bold;
	background-color:#05203E;
	color:white;
}

.eml1{
	font-size:20px;
	font-weight:bold;
	background-color:#AED6F1;
}

.emp2{
	font-size:16px; 
	font-weight:bold;
}

.seml{
	font-size:15px;
	font-weight:bold;
	background-color:#CCD1D1;
}

</style>

<div class="wrap">
	<section class="app-content">


		<div class="row">
		<form id="form_mgnt_user" method="POST" action="">

			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="12" id="theader" style="font-size:30px"><!-- <img src="<?php echo base_url(); ?>main_img/msb.png"> -->AGENT HCCI REVIEW</td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
									
									<tr>
										<td>QA Name:</td>
										<?php if($agnt_feedback['entry_by']!=''){
												$auditorName = $agnt_feedback['auditor_name'];
											}else{
												$auditorName = $agnt_feedback['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($agnt_feedback['audit_date']); ?>" disabled></td>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled="">
												<option value="<?php echo $agnt_feedback['agent_id'] ?>"><?php echo $agnt_feedback['fname']." ".$agnt_feedback['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>										
										<td>Fusion ID:</td>
										<td><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $agnt_feedback['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" disabled>
												<option value="<?php echo $agnt_feedback['tl_id'] ?>"><?php echo $agnt_feedback['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
										<td>Contact Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($agnt_feedback['call_date']) ?>" disabled></td>
									</tr>
									<tr>										
										<td>Contact Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $agnt_feedback['call_duration'] ?>" disabled></td>
										<td>SR No:</td>
										<td><input type="text" class="form-control" id="sr_no" name="data[sr_no]" value="<?php echo $agnt_feedback['sr_no'] ?>" disabled></td>
										<td>Consumer No:</td>
										<td><input type="text" class="form-control" id="consumer_no" name="data[consumer_no]" value="<?php echo $agnt_feedback['consumer_no'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Call File:</td>
										<td><input type="text" class="form-control" id="call_file" name="data[call_file]" value="<?php echo $agnt_feedback['call_file'] ?>" disabled></td>
										<td>Call scenario:</td>
										<td>
											<select class="form-control"  id="call_scenario" name="data[call_scenario]" disabled>
												<option value="">-Select-</option>
												<option value="Customer Critical">Customer Critical</option>
												<option value="Business Critical">Business Critical</option>
												<option value="Compliance Critical">Compliance Critical</option>
												
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="<?php echo $agnt_feedback['voc'] ?>"><?php echo $agnt_feedback['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $agnt_feedback['audit_type'] ?>"><?php echo $agnt_feedback['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option <?php echo $agnt_feedback['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $agnt_feedback['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td style="font-size:18px; font-weight:bold">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold"><input type="text" readonly class="form-control" value="<?php echo $agnt_feedback['overall_score'] ?>"></td>
									</tr>
									<?php /////////perfect start first part/////////////// ?>
									<tr><td class="eml2" colspan="6">Product Knowledge & Process Adherence</td></tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">1. Use the appropriate HCCI introduction 
										</td>
										<td class="eml">
											<select class="form-control points business" name="data[HCCI_introduction]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['HCCI_introduction']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['HCCI_introduction']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['HCCI_introduction']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Business</td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">2. Demonstrate a willingness to help throughout the call
										</td>

										<td class="eml">
										<select class="form-control hcci hccicall customer" id="demonstrate" name="data[throughout_the_call]" disabled="">
												<!-- <option data-valnum=1 value="Yes">Yes</option>
												<option data-valnum=1 value="No">No</option> -->
												<option value="Yes" <?php echo $agnt_feedback['throughout_the_call']=="Yes"?"selected":""; ?>>Yes</option>
												<option value="No" <?php echo $agnt_feedback['throughout_the_call']=="No"?"selected":""; ?>>No</option>
												
											</select>
										</td>
										<td class="eml">Customer</td>
									</tr>
										<tr>
										<td class="eml" colspan="4" >a. Use RRA (Repeat, Rephrase, and Affirm) 
										</td>
										<td class="eml">
											<select class="form-control hcci" name="data[Use_RRA]" id="hcciAF3" disabled>
												<!-- <option  value="Yes">Yes</option>
												<option  value="No">No</option> -->
												<option value="Yes" <?php echo $agnt_feedback['Use_RRA']=="Yes"?"selected":""; ?>>Yes</option>
												<option value="No" <?php echo $agnt_feedback['Use_RRA']=="No"?"selected":""; ?>>No</option>
												<option value="N/A" <?php echo $agnt_feedback['Use_RRA']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml"></td>
									</tr>
									<tr>
										<td class="eml" colspan="4" >b. Used empathetic word choices 
										</td>
										<td class="eml">
											<select class="form-control hcci" name="data[word_choices]" id="hcciAF4" disabled>
												<!-- <option  value="Yes">Yes</option>
												<option  value="No">No</option> -->
												<option value="Yes" <?php echo $agnt_feedback['word_choices']=="Yes"?"selected":""; ?>>Yes</option>
												<option value="No" <?php echo $agnt_feedback['word_choices']=="No"?"selected":""; ?>>No</option>
											</select>
										</td>
										<td class="eml"></td>
									</tr>
									<tr>
										<td class="eml" colspan="4" >c. Feel, felt, found 
										</td>
										<td class="eml">
											<select class="form-control hcci" name="data[felt_found]" id="hcciAF5" disabled>
												<!-- <option  value="Yes">Yes</option>
												<option  value="No">No</option> -->
												<option value="Yes" <?php echo $agnt_feedback['felt_found']=="Yes"?"selected":""; ?>>Yes</option>
												<option value="No" <?php echo $agnt_feedback['felt_found']=="No"?"selected":""; ?>>No</option>
											</select>
										</td>
										<td class="eml"></td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;"> 3. Thoroughly probed to identify customer needs
										</td>
										<td class="eml">
											<select class="form-control points customer" name="data[customer_needs]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['customer_needs']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['customer_needs']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['customer_needs']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Customer</td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">4. Accurately address all questions/issues presented
										</td>
										<td class="eml">
											<select class="form-control points customer" name="data[issues_presented]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['issues_presented']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['issues_presented']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['issues_presented']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Customer</td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">5.  Set appropriate expectations on policy and next steps
										</td>
										<td class="eml">
											<select class="form-control points customer" name="data[next_steps]" disabled>
												<option data-valnum=1 value="yes" <?php echo $agnt_feedback['next_steps']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['next_steps']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['next_steps']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Customer</td>
									</tr>
									<tr>
										<td class="eml" colspan=4 style="text-align: left;">6. Use appropriate user-facing terms and Book Now acronyms </td>
										<td class="eml">
											<select class="form-control points business"  name="data[now_acronyms]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['now_acronyms']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['now_acronyms']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['now_acronyms']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Business</td>
									</tr>
									<tr>
										<td class="eml" colspan=4 style="text-align: left;">7. Warm transferred when required (N/A if not applicable)</td>
										<td class="eml">
											<select class="form-control points customer"  name="data[when_required]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['when_required']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['when_required']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['when_required']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Customer</td>
									</tr>
									<tr>
										<td class="eml" colspan=4 style="text-align: left;">8. Thank customer for their business and brand the call </td>
										<td class="eml">
											<select class="form-control points business"  name="data[brand_the_call]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['brand_the_call']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['brand_the_call']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['brand_the_call']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Business</td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">9. Completed all actions in Dash as communicated to customer
										</td>
										<td class="eml">
											<select class="form-control points customer" name="data[communicated_to_customer]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['communicated_to_customer']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['communicated_to_customer']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['communicated_to_customer']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Customer</td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="color:red; text-align: left;" >10. Did not promise or complete an action out of policy? (auto-fail)
										</td>
										<td class="eml">
											<select class="form-control points compliance" id="hcciAF1" name="data[out_of_policy]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['out_of_policy']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['out_of_policy']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['out_of_policy']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Compliance</td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="color:red; text-align: left;" >11. Completed the appropriate documentation and action in Dash? (auto-fail)
										</td>
										<td class="eml">
											<select class="form-control points customer" id="hcciAF2" name="data[action_in_Dash]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['action_in_Dash']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['action_in_Dash']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['action_in_Dash']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Customer</td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">12. Completed Lead Audit Interview on SR in BETTI
										</td>
										<td class="eml">
											<select class="form-control points business" name="data[SR_in_BETTI]" disabled>
												<option data-valnum=1 value="Yes" <?php echo $agnt_feedback['SR_in_BETTI']=="Yes"?"selected":""; ?>>Yes</option>
												<option data-valnum=1 value="No" <?php echo $agnt_feedback['SR_in_BETTI']=="No"?"selected":""; ?>>No</option>
												<option data-valnum=0 value="N/A" <?php echo $agnt_feedback['SR_in_BETTI']=="N/A"?"selected":""; ?>>N/A</option>
											</select>
										</td>
										<td class="eml">Business</td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">13. Asked a strategic SR question
										</td>
										<td class="eml">
											<select class="form-control points business" name="data[SR_question]" disabled>
												<option data-valnum=1 value="Yes">Yes</option>
												<option data-valnum=1 value="No">No</option>
												<option data-valnum=0 value="N/A">N/A</option>
											</select>
										</td>
										<td class="eml">Business</td>
									</tr>
									<tr><td class="eml2" colspan="6">COACHING FAILS</td></tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">14. Cursing / Clear Insults
										</td>
										<td class="eml">
											<select class="form-control" name="data[Clear_Insults]" required>
												<option data-valnum=1 value="Pass" <?php echo $agnt_feedback['Clear_Insults']=="Pass"?"selected":""; ?>>Pass</option>
												<option data-valnum=1 value="Fail" <?php echo $agnt_feedback['Clear_Insults']=="Fail"?"selected":""; ?>>Fail</option>
												
											</select>
										</td>
										<td class="eml"></td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">15. Speaking Negatively of Handy / Users / Partners / CX Agents
										</td>
										<td class="eml">
											<select class="form-control " name="data[CX_Agents]" required>
												<option data-valnum=1 value="Pass" <?php echo $agnt_feedback['CX_Agents']=="Pass"?"selected":""; ?>>Pass</option>
												<option data-valnum=1 value="Fail" <?php echo $agnt_feedback['CX_Agents']=="Fail"?"selected":""; ?>>Fail</option>
											</select>
										</td>
										<td class="eml"></td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">16. Ignored main issue 
										</td>
										<td class="eml">
											<select class="form-control " name="data[main_issue]" required>
												<option data-valnum=1 value="Pass" <?php echo $agnt_feedback['main_issue']=="Pass"?"selected":""; ?>>Pass</option>
												<option data-valnum=1 value="Fail" <?php echo $agnt_feedback['main_issue']=="Fail"?"selected":""; ?>>Fail</option>
											</select>
										</td>
										<td class="eml"></td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">17. Excessive Inappropriate Response or Tone of Voice
										</td>
										<td class="eml">
											<select class="form-control " name="data[tone_of_Voice]" required>
												<option data-valnum=1 value="Pass" <?php echo $agnt_feedback['tone_of_Voice']=="Pass"?"selected":""; ?>>Pass</option>
												<option data-valnum=1 value="Fail" <?php echo $agnt_feedback['tone_of_Voice']=="Fail"?"selected":""; ?>>Fail</option>
											</select>
										</td>
										<td class="eml"></td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">18. Excessive Dead Air
										</td>
										<td class="eml">
											<select class="form-control " name="data[Dead_Air]" required>
												<option data-valnum=1 value="Pass" <?php echo $agnt_feedback['Dead_Air']=="Pass"?"selected":""; ?>>Pass</option>
												<option data-valnum=1 value="Fail" <?php echo $agnt_feedback['Dead_Air']=="Fail"?"selected":""; ?>>Fail</option>
											</select>
										</td>
										<td class="eml"></td>
									</tr>
									<tr>
										<td class="eml" colspan="4" style="text-align: left;">19. Incorrectly using an Other Disposition when there was a better option available
										</td>
										<td class="eml">
											<select class="form-control " name="data[option_available]" required>
												<option data-valnum=1 value="Pass" <?php echo $agnt_feedback['option_available']=="Pass"?"selected":""; ?>>Pass</option>
												<option data-valnum=1 value="Fail" <?php echo $agnt_feedback['option_available']=="Fail"?"selected":""; ?>>Fail</option>
											</select>
										</td>
										<td class="eml"></td>
									</tr>
									<?php // completed all tally only one column name is need to chang ?>
									<tr>
										<td colspan="2">Call Summary:</td>
										<td colspan="4"><textarea class="form-control" id="call_summary" name="data[call_summary]" disabled=""><?php echo $agnt_feedback['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Feedback:</td>
										<td colspan="4"><textarea class="form-control" id="feedback" name="data[feedback]" disabled><?php echo $agnt_feedback['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($agnt_feedback['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$agnt_feedback['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $agnt_feedback['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $agnt_feedback['client_rvw_note'] ?></td></tr>
									<!-- <tr><td style="font-size:16px">Your Review:</td> <td colspan="5" style="text-align:left"><?php echo $agnt_feedback['agent_rvw_note']; ?></td></tr> -->
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $agnt_feedback['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $agnt_feedback['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $agnt_feedback['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($agnt_feedback['entry_date'],72) == true){ ?>
											<tr>
												<?php if($agnt_feedback['agent_rvw_note']==''){ ?>
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
