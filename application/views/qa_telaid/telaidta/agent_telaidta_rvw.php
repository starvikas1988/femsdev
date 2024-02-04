
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
	background-color:rgb(221,235,247);
}

.eml2{
	font-size:24px;
	font-weight:bold;
	background-color:rgb(34,43,53);
	color:white;
}

.eml3{
	font-size:24px;
	font-weight:bold;
	background-color:rgb(48,84,150);
	color:white;
}

.eml1{
	font-size:30px;
	font-weight:bold;
	background-color:rgb(4,50,255);
	color:white;
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
										<td colspan="9" id="theader" style="font-size:30px">Agent TelAid TA Rvw<!-- <img src="<?php echo base_url(); ?>main_img/hra.png"> --></td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
										
									<tr>
										<td colspan="1">QA Name:</td>
										<?php 
										$dataDetails=$page."_agnt_feedback";
										if($$dataDetails['entry_by']!=''){
												$auditorName = $$dataDetails['auditor_name'];
											}else{
												$auditorName = $$dataDetails['client_name'];
										} ?>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td colspan="1">Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($$dataDetails['audit_date']); ?>" disabled></td>
										<td colspan="1">Call Id.:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_id" name="data[call_id]" value="<?php echo $$dataDetails['call_id'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $$dataDetails['agent_id'] ?>"><?php echo $$dataDetails['fname']." ".$$dataDetails['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:</td>
										<td colspan="2"><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $$dataDetails['fusion_id'] ?>"></td>
										<td colspan="1">L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]"  disabled>
												<option value="<?php echo $$dataDetails['tl_id'] ?>"><?php echo $$dataDetails['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="1">Call_type:</td>
										<td colspan="2"><input type="text" class="form-control"  name="data[call_type]" value="<?php echo $$dataDetails['call_type'] ?>"  disabled></td>
										<td colspan="1">Contact Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($$dataDetails['call_date']) ?>" disabled></td>
										<td colspan="1">Contact Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $$dataDetails['call_duration'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $$dataDetails['audit_type'] ?>"><?php echo $$dataDetails['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]"  disabled>
												<option value="<?php echo $$dataDetails['voc'] ?>"><?php echo $$dataDetails['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
										<tr>
										<td colspan="1">ACPT:</td>
										<td colspan="2">
											<select class="form-control" id="" name="data[acpt]" required>
												<option value="<?php echo $$dataDetails['acpt'] ?>"><?php echo $$dataDetails['acpt'] ?></option>
												<option value="">-Select-</option>
												<option value="Agent">Agent</option>
												<option value="Customer">Customer</option>
												<option value="Process">Process</option>
												<option value="Technology">Technology</option>
											</select>
										</td>
									</tr>
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]" value="<?php echo $$dataDetails['cust_score'] ?>" readonly></td><td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]" value="<?php echo $$dataDetails['busi_score'] ?>" readonly></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]" value="N/A" readonly></td>
									</tr>
									<tr>										
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="earnedScore" name="data[earned_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="possibleScore" name="data[possible_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value="<?php echo $$dataDetails['overall_score'] ?>" disabled></td>
									</tr>
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=5>Sub Category</td>
										<td class="eml2">Status</td>
										<td class="eml2" colspan=4>Remarks</td>
									</tr>
										<tr style="height:40px">
										<td style="background-color:rgb(0,32,96);color:white;font-size: 30px;font-weight: bold" colspan="9">Business Critical</td>
										
									</tr>
									<tr>
										<td rowspan="4" class="eml1">1</td>
										<td class="eml3" colspan=5>Did the agent execute properly any of the Escalation? 
										</td>
										<td rowspan="4">
											<select class="form-control points_epi busi_score" name="data[identifynameatbeginning]" disabled>
												<option ds_val=3 value="Yes" <?php echo $$dataDetails['identifynameatbeginning']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3 value="No" <?php echo $$dataDetails['identifynameatbeginning']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3 value="N/A" <?php echo $$dataDetails['identifynameatbeginning']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td rowspan=4 colspan=1><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $$dataDetails['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">1.1</td>
										<td class="eml" colspan=4>Agent correctly escalated to the appropriate level and send email to PM when necessary.</td>
									</tr>
									<tr>
										<td class="eml">1.2</td>
										<td class="eml" colspan=4>Direct the technician to the previous Techincal Analyst if ever they requested it (call disconnected or no response from technician after callback)</td>
									</tr>
									<tr>
										<td class="eml">1.3</td>
										<td class="eml" colspan=4>Agent notifies and/or escalates via Teams chat for follow-up.</td>
									</tr>
									<tr>
										<td rowspan="5" class="eml1">2</td>
										<td class="eml3" colspan=5>Documentation: Properly filled case fields</td>
										<td rowspan="5">
											<select class="form-control points_epi busi_score"  name="data[assurancetsatementverbatim]" disabled>
												<option ds_val=1 value="Yes" <?php echo $$dataDetails['assurancetsatementverbatim']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1 value="No" <?php echo $$dataDetails['assurancetsatementverbatim']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1 value="N/A" <?php echo $$dataDetails['assurancetsatementverbatim']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td rowspan="5" colspan=1><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $$dataDetails['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">2.1</td>
										<td class="eml" colspan=4>Duplicate cases are properly tied to their parent ticket</td>
									</tr>
									<tr>
										<td class="eml">2.2</td>
										<td class="eml" colspan=4>Complete documentation on the note field.</td>
									</tr>
									<tr>
										<td class="eml">2.3</td>
										<td class="eml" colspan=4>Provided closure notes survey and closed task upon completion.</td>
									</tr>
									<tr>
										<td class="eml">2.4</td>
										<td class="eml" colspan=4>Standard Closure Note visible on Service Now.</td>
									</tr>
									
									<tr>
										<td rowspan="7" class="eml1">3</td>
										<td class="eml3" colspan=5> Documentation: Complete and Accurate case comments</td>
										<td rowspan="7">
											<select class="form-control points_epi busi_score"  name="data[msbFinancial]" disabled>
												<option ds_val=3 value="Yes" <?php echo $$dataDetails['msbFinancial']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3 value="No" <?php echo $$dataDetails['msbFinancial']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3 value="N/A" <?php echo $$dataDetails['msbFinancial']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td rowspan="7" colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $$dataDetails['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">3.1</td>
										<td class="eml" colspan=4>All information relevant to the interaction is captured (Name of the caller if it’s not the same as found in 3C, PRJ/Assignment IDs, troubleshooting steps taken, Resolution to the case, etc.) </td>
									</tr>
									<tr>
										<td class="eml">3.2</td>
										<td class="eml" colspan=4>If it is clearly documented when a call disconnects and the caller has to be called back. If performing any follow up, this should be documented as well. </td>
									</tr>
									<tr>
										<td class="eml">3.3</td>
										<td class="eml" colspan=4>Case notes are input on the TA/Labor ticket.</td>
									</tr>
									<tr>
										<td class="eml">3.4</td>
										<td class="eml" colspan=4>Agent refrains from negative or derogatory comments about customers, fellow employees or services within their case notes.</td>
									</tr>
									<tr>
										<td class="eml">3.5</td>
										<td class="eml" colspan=4>Notes were visible on ServiceNow.</td>
									</tr>
									<tr>
										<td class="eml">3.6</td>
										<td class="eml" colspan=4>Agent reviewed previous notes.</td>
									</tr>
									
									<tr>
										<td rowspan="7" class="eml1">4</td>
										<td class="eml3" colspan=5>Did the agent followed proper call handling?</td>
										<td rowspan="7">
											<select class="form-control points_epi busi_score"  name="data[speakingtorightparty]" disabled>
												<option ds_val=1 value="Yes" <?php echo $$dataDetails['speakingtorightparty']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1 value="No" <?php echo $$dataDetails['speakingtorightparty']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1 value="N/A" <?php echo $$dataDetails['speakingtorightparty']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td rowspan="7" colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $$dataDetails['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">4.1</td>
										<td class="eml" colspan=4>Agent mentions the brand "TelAid" together with the recommended spiels during opening and closing.</td>
									</tr>
									<tr>
										<td class="eml">4.2</td>
										<td class="eml" colspan=4>Agent unable to answer the call within 15-20 seconds.</td>
									</tr>
									<tr>
										<td class="eml">4.3</td>
										<td class="eml" colspan=4>Whenever doing an outbound call and routed to voicemail, agent makes proper introduction by giving his/her name, company, ticket number, and concern of the call.</td>
									</tr>
									<tr>
										<td class="eml">4.4</td>
										<td class="eml" colspan=4>Agent did not use the ghost call spiel.</td>
									</tr>
									<tr>
										<td class="eml">4.5</td>
										<td class="eml" colspan=4>Agent asked for caller's name, verified location (city, state and store type), and confirmed contact information (callback number)</td>
									</tr>
									<tr>
										<td class="eml">4.6</td>
										<td class="eml" colspan=4>During outbound call, agent advised regarding call recording.</td>
									</tr>
									<tr style="height:40px">
										<td style="background-color:rgb(0,32,96);color:white;font-size: 30px;font-weight: bold" colspan="9">Customer Critical</td>
										
										</tr>
									<tr>
										<td rowspan="4" class="eml1">5</td>
										<td class="eml3" colspan=5>Product Information and Scope of Support</td>
										<td rowspan="4">
											<select class="form-control points_epi cust_score"  name="data[SbSResolution]" disabled>
												<option ds_val=1 value="Yes" <?php echo $$dataDetails['SbSResolution']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1 value="No" <?php echo $$dataDetails['SbSResolution']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1 value="N/A" <?php echo $$dataDetails['SbSResolution']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td rowspan="4" colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $$dataDetails['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">5.1</td>
										<td class="eml" colspan=4>Agent accurately provides any information within the scope.</td>
									</tr>
									<tr>
										<td class="eml">5.2</td>
										<td class="eml" colspan=4>Uses appropriate and logical probing questions, pays attention to key words and phrases to quickly determine the issue which are tailored to caller's issue.</td>
									</tr>
									<tr>
										<td class="eml">5.3</td>
										<td class="eml" colspan=4>Agent asks confirmation to the caller if the problem is resolve and if there are any other concerns.</td>
									</tr>
									<tr>
										<td rowspan="5" class="eml1">6</td>
										<td class="eml3" colspan=5>Soft Skills: courtesy, positive tone, and active listening</td>
										<td rowspan="5">
											<select class="form-control points_epi cust_score"  name="data[demographicsinformation]" disabled>
												<option ds_val=1 value="Yes" <?php echo $$dataDetails['demographicsinformation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1 value="No" <?php echo $$dataDetails['demographicsinformation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1 value="N/A" <?php echo $$dataDetails['demographicsinformation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td rowspan="5" colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $$dataDetails['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">6.1</td>
										<td class="eml" colspan=4>Immediately and appropriately acknowledges and responds to the caller’s emotional statements or tone while  actively controls the interaction</td>
									</tr>
									<tr>
										<td class="eml">6.2</td>
										<td class="eml" colspan=4>Maintains a friendly, confident and professional voice tone throughout the interaction</td>
									</tr>
									<tr>
										<td class="eml">6.3</td>
										<td class="eml" colspan=4>Demonstrates active listening by not ignoring caller's information or interrupting without a courteous attempt to yield the conversation</td>
									</tr>
									<tr>
										<td class="eml">6.4</td>
										<td class="eml" colspan=4>Understand the issue on first instance and answers issues on a swift manner.</td>
									</tr>
									<tr>
										<td rowspan="3" class="eml1">7</td>
										<td class="eml3" colspan=5>Soft Skills: Setting expectations during the interaction</td>
										<td rowspan="3">
											<select class="form-control points_epi cust_score"  name="data[minimirandadisclosure]" disabled>
												<option ds_val=3 value="Yes" <?php echo $$dataDetails['minimirandadisclosure']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3 value="No" <?php echo $$dataDetails['minimirandadisclosure']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3 value="N/A" <?php echo $$dataDetails['minimirandadisclosure']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td rowspan="3" colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $$dataDetails['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">7.1</td>
										<td class="eml" colspan=4>Agent appropriately advises of ticket status, next steps, and relevant time frames. </td>
									</tr>
									<tr>
										<td class="eml">7.2</td>
										<td class="eml" colspan=4>Agent follows proper hold procedures and mute expectations (i.e. provides an expected time of hold, specifies if it is to be a silent or regular hold, and asks permission to </td>
									</tr>
									<tr>
										<td rowspan="2" class="eml1">8</td>
										<td class="eml3" colspan=5>Soft Skills: Communication   
										</td>
										<td rowspan="2">
											<select class="form-control points_epi cust_score"  name="data[statetheclientname]" disabled>
												<option ds_val=1 value="Yes" <?php echo $$dataDetails['statetheclientname']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1 value="No" <?php echo $$dataDetails['statetheclientname']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1 value="N/A" <?php echo $$dataDetails['statetheclientname']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td rowspan="2" colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $$dataDetails['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">8.1</td>
										<td class="eml" colspan=4>Agent displays clear statements.</td>
									</tr>
									<!-- <tr>
										<td rowspan="3" class="eml1">9</td>
										<td class="eml3" colspan=5>Did the agent properly execute any process for SOFT SKILLS: use proper spelling and grammar for all written or verbal customer-facing communication?   
										</td>
										<td rowspan="3">
										<select class="form-control points_epi cust_score"  name="data[askforbalancedue]" disabled>
												<option ds_val=1 value="Yes" <?php echo $$dataDetails['askforbalancedue']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1 value="No" <?php echo $$dataDetails['askforbalancedue']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1 value="N/A" <?php echo $$dataDetails['askforbalancedue']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td rowspan="3" colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $$dataDetails['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">9.1</td>
										<td class="eml" colspan=4>Agent using grammatically correct phrases and sentences during the call and documentation.</td>
									</tr>
									<tr>
										<td class="eml">9.2</td>
										<td class="eml" colspan=4>Agent displays clear communication.</td>
									</tr> -->
									<tr>
										<td colspan="3">Call Summary:</td>
										<td colspan="6"><textarea class="form-control" id="call_summary" name="data[call_summary]"><?php echo $$dataDetails['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="3">Feedback:</td>
										<td colspan="6"><textarea class="form-control" id="feedback" name="data[feedback]"><?php echo $$dataDetails['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($$dataDetails['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="3">Audio Files</td>
										<td colspan="6">
											<?php $attach_file = explode(",",$$dataDetails['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio controls='' style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_telaid/telaidta/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_telaid/telaidta/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px" colspan="2">Manager Review:</td> <td colspan="7" style="text-align:left"><?php echo $$dataDetails['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px" colspan="2">Client Review:</td> <td colspan="7" style="text-align:left"><?php echo $$dataDetails['client_rvw_note'] ?></td></tr>
									<!-- <tr><td style="font-size:16px">Your Review:</td> <td colspan="5" style="text-align:left"><?php echo $$dataDetails['agent_rvw_note']; ?></td></tr> -->
									
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<tr>
											<td colspan="3"  style="font-size:16px">Your Review
												<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
											</td>
											<td colspan="6"><textarea class="form-control" name="note" required><?php echo $$dataDetails['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($$dataDetails['entry_date'],72) == true){ ?>
											<tr>
												<?php if($$dataDetails['agent_rvw_note']==''){ ?>
													<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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