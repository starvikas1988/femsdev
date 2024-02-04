
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
	background-color:#008B8B;
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
							<table class="table table-striped skt-table" width="100%" oncontextmenu="return false;">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="9" id="theader" style="font-size:30px">Agent <?php echo ucfirst($page) ?> Rvw<!-- <img src="<?php echo base_url(); ?>main_img/hra.png"> --></td>
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
										<td>Sampling:</td>
										<td colspan=2><input type="text" class="form-control" id="" name="data[qa_sampling]" value="<?php echo $$dataDetails['qa_sampling'] ?>" disabled></td>
									</tr>
									<tr>
										<td>MC Disposition:</td>
										<td class="nonSale_epi" colspan="2">
											<select class="form-control" id="" name="data[mc_disposition]" disabled>
												<option value="<?php echo $$dataDetails['mc_disposition'] ?>"><?php echo $$dataDetails['mc_disposition'] ?></option>
											</select>
										</td>
										<td>Order Number:</td>
										<td colspan=2><input type="text" class="form-control" id="" name="data[order_no]" value="<?php echo $$dataDetails['order_no'] ?>" disabled></td>
										<td>Sub Category:</td>
										<td colspan=2><input type="text" class="form-control" id="" name="data[sub_category]" value="<?php echo $$dataDetails['sub_category'] ?>" disabled></td>
									</tr>
									<tr>
										<td>NPS:</td>
										<td colspan=2><input type="text" class="form-control" id="" name="data[nps]" value="<?php echo $$dataDetails['nps'] ?>" disabled></td>
										<td>CSAT:</td>
										<td colspan=2><input type="text" class="form-control" id="" name="data[csat]" value="<?php echo $$dataDetails['csat'] ?>" disabled></td>
										<td>20% Deduction:</td>
										<td colspan=2>
											<select class="form-control deduct_20_perc" id="deduct_20_perc" name="data[deduction_20_percent]" disabled>
												<option value="">Select</option>
												<option value="Yes" <?php echo $$dataDetails['deduction_20_percent']=="Yes"?"selected":""; ?>>Yes</option>
												<option value="No" <?php echo $$dataDetails['deduction_20_percent']=="No"?"selected":""; ?> >No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]" value="<?php echo $$dataDetails['cust_score'] ?>" readonly></td><td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]" value="<?php echo $$dataDetails['busi_score'] ?>" readonly></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]" value="<?php echo $$dataDetails['comp_score'] ?>" readonly></td>
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
										<td class="eml2" colspan=4>Sub Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=4>Remarks</td>
									</tr>
									<tr>
										<td rowspan=10 class="eml1">CALL STRUCTURE</td>
										<td class="eml" colspan=4>Call Opening
										</td>
										<td>
											<select class="form-control points_epi cust_score" name="data[call_opening]" disabled>
												<option ds_val=5 value="Yes" <?php echo $$dataDetails['call_opening']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=5 value="No" <?php echo $$dataDetails['call_opening']=="No"?"selected":""; ?> >No</option>
												<option ds_val=5 value="N/A" <?php echo $$dataDetails['call_opening']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><textarea class="form-control" disabled name="data[cmt1]"><?php echo $$dataDetails['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Account Verification</td>
										<td>
											<select class="form-control points_epi comp_score"  name="data[account_verification]" disabled>
												<option ds_val=5 value="Yes" <?php echo $$dataDetails['account_verification']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=5 value="No" <?php echo $$dataDetails['account_verification']=="No"?"selected":""; ?> >No</option>
												<option ds_val=5 value="N/A" <?php echo $$dataDetails['account_verification']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><textarea class="form-control" disabled name="data[cmt2]"><?php echo $$dataDetails['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Concern and Assurance</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[concern_assurance]" disabled>
												<option ds_val=10 value="Yes" <?php echo $$dataDetails['concern_assurance']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=10 value="No" <?php echo $$dataDetails['concern_assurance']=="No"?"selected":""; ?> >No</option>
												<option ds_val=10 value="N/A" <?php echo $$dataDetails['concern_assurance']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt3]"><?php echo $$dataDetails['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>P.A.T.I.E.N.C.E. (Pace, Tone and Energy)</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[tone_energy]" disabled>
												<option ds_val=15 value="Yes" <?php echo $$dataDetails['tone_energy']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=15 value="No" <?php echo $$dataDetails['tone_energy']=="No"?"selected":""; ?> >No</option>
												<option ds_val=15 value="N/A" <?php echo $$dataDetails['tone_energy']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt4]"><?php echo $$dataDetails['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Rapport and Empathy</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[rapport_empathy]" disabled>
												<option ds_val=15 value="Yes" <?php echo $$dataDetails['rapport_empathy']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=15 value="No" <?php echo $$dataDetails['rapport_empathy']=="No"?"selected":""; ?> >No</option>
												<option ds_val=15 value="N/A" <?php echo $$dataDetails['rapport_empathy']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt5]"><?php echo $$dataDetails['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Probing</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[probing]" disabled>
												<option ds_val=10 value="Yes" <?php echo $$dataDetails['probing']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=10 value="No" <?php echo $$dataDetails['probing']=="No"?"selected":""; ?> >No</option>
												<option ds_val=10 value="N/A" <?php echo $$dataDetails['probing']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt6]"><?php echo $$dataDetails['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Conveyance and Resolution</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[conveyance_resolution]" disabled>
												<option ds_val=15 value="Yes" <?php echo $$dataDetails['conveyance_resolution']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=15 value="No" <?php echo $$dataDetails['conveyance_resolution']=="No"?"selected":""; ?> >No</option>
												<option ds_val=15 value="N/A" <?php echo $$dataDetails['conveyance_resolution']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt7]"><?php echo $$dataDetails['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Proper Hold Procedure</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[proper_procedure]" disabled>
												<option ds_val=10 value="Yes" <?php echo $$dataDetails['proper_procedure']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=10 value="No" <?php echo $$dataDetails['proper_procedure']=="No"?"selected":""; ?> >No</option>
												<option ds_val=10 value="N/A" <?php echo $$dataDetails['proper_procedure']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt8]"><?php echo $$dataDetails['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Recap and Closing Statement </td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[recap_statement]" disabled>
												<option ds_val=5 value="Yes" <?php echo $$dataDetails['recap_statement']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=5 value="No" <?php echo $$dataDetails['recap_statement']=="No"?"selected":""; ?> >No</option>
												<option ds_val=5 value="N/A" <?php echo $$dataDetails['recap_statement']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt9]"><?php echo $$dataDetails['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Objections Handling</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[objections_handling]" disabled>
												<option ds_val=10 value="Yes" <?php echo $$dataDetails['objections_handling']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=10 value="No" <?php echo $$dataDetails['objections_handling']=="No"?"selected":""; ?> >No</option>
												<option ds_val=10 value="N/A" <?php echo $$dataDetails['objections_handling']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt10]"><?php echo $$dataDetails['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 class="eml1">PROCESS ADHERENCE</td>
										<td class="eml" colspan=4>Returns Tagging</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[returns_tagging]" disabled>
												<option ds_val=20 value="Yes" <?php echo $$dataDetails['returns_tagging']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=20 value="No" <?php echo $$dataDetails['returns_tagging']=="No"?"selected":""; ?> >No</option>
												<option ds_val=20 value="N/A" <?php echo $$dataDetails['returns_tagging']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt11]"><?php echo $$dataDetails['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Correct grammar use </td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[documentation]" disabled>
												<option ds_val=30 value="Yes" <?php echo $$dataDetails['documentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=30 value="No" <?php echo $$dataDetails['documentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=30 value="N/A" <?php echo $$dataDetails['documentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt12]"><?php echo $$dataDetails['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Reviewed Next Steps</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[actions_taken]" disabled>
												<option ds_val=50 value="Yes" <?php echo $$dataDetails['actions_taken']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=50 value="No" <?php echo $$dataDetails['actions_taken']=="No"?"selected":""; ?> >No</option>
												<option ds_val=50 value="N/A" <?php echo $$dataDetails['actions_taken']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled name="data[cmt13]"><?php echo $$dataDetails['cmt13'] ?></textarea></td>
									</tr>
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
													  <source src="<?php echo base_url(); ?>qa_files/qa_ibuumerang/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ibuumerang/<?php echo $af; ?>" type="audio/mpeg">
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
									 	<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
									 	<tr>
											<td colspan=3 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $$dataDetails['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $$dataDetails['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="3"  style="font-size:16px">Your Review
												
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