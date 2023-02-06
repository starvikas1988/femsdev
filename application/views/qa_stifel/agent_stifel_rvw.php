
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
	background-color:#85C1E9;
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
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">Stifel Scorecard</td></tr>
									
									<tr>
										<td>QA Name:</td>
										<?php if($stifel['entry_by']!=''){
												$auditorName = $stifel['auditor_name'];
											}else{
												$auditorName = $stifel['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($stifel['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($stifel['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $stifel['fname']." ".$stifel['lname']." - [".$stifel['fusion_id']."]" ?></option>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td><select class="form-control" disabled><option><?php echo $stifel['tl_name'] ?></option></select></td>
										<td>Interaction ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $stifel['interaction_id'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" value="<?php echo $stifel['call_duration'] ?>" disabled></td>
										<td>Hold Duration:</td>
										<td><input type="text" class="form-control" value="<?php echo $stifel['hold_duration'] ?>" disabled></td>
										<td>Verification Duration:</td>
										<td><input type="text" class="form-control" value="<?php echo $stifel['verification_duration'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $stifel['audit_type'] ?></option></select></td>
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $stifel['voc'] ?></option></select></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" class="form-control" style="font-weight:bold" value="<?php echo $stifel['overall_score'] ?>" disabled></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D2B4DE">
										<td>PARAMETER</td>
										<td colspan=2>SUB PARAMETER</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Critical Error</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Greeting and Farewell</td>
										<td colspan=2>Opening</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[opening]" disabled>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $stifel['opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $stifel['opening'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=5 <?php echo $stifel['opening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $stifel['cmt1'] ?>" disabled></td>
										<td>Customer Critical</td>
									</tr>
									<!-- <tr>
										<td colspan=2>Recording Verbiage</td>
										<td>
											<select class="form-control jurry_points business" name="data[recording_verbiage]" disabled>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['recording_verbiage'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['recording_verbiage'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $stifel['recording_verbiage'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $stifel['cmt2'] ?>" disabled></td>
									</tr> -->
									<tr>
										<td colspan=2>Closing</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[closing]" disabled>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $stifel['closing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $stifel['closing'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=5 <?php echo $stifel['closing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $stifel['cmt3'] ?>" disabled></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Empathy and Ownership</td>
										<td colspan=2>Empathy / Apology</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[empathy_apology]" disabled>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['empathy_apology'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['empathy_apology'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['empathy_apology'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $stifel['cmt4'] ?>" disabled></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Ownership / Assurance</td>
										<td>9</td>
										<td>
											<select class="form-control jurry_points customer" name="data[owenship_assurance]" disabled>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $stifel['owenship_assurance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $stifel['owenship_assurance'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=5 <?php echo $stifel['owenship_assurance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $stifel['cmt5'] ?>" disabled ></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Hold and Escalation Protocol</td>
										<td colspan=2>Call Control</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[hold_protocol]" disabled>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $stifel['hold_protocol'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $stifel['hold_protocol'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=5 <?php echo $stifel['hold_protocol'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $stifel['cmt6'] ?>" disabled></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Transfer</td>
										<td>9</td>
										<td>
											<select class="form-control jurry_points business" name="data[transfer]" disabled>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $stifel['transfer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $stifel['transfer'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=5 <?php echo $stifel['transfer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $stifel['cmt7'] ?>" disabled></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Effective Communication</td>
										<td colspan=2>Tone / Rate Of Speech / Fumbling/ Pacing</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[rate_of_speech]" disabled>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $stifel['rate_of_speech'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=5 <?php echo $stifel['rate_of_speech'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $stifel['rate_of_speech'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $stifel['cmt8'] ?>" disabled></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Active Listening</td>
										<td>9</td>
										<td>
											<select class="form-control jurry_points customer" name="data[active_listening]" disabled>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $stifel['active_listening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $stifel['active_listening'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=5 <?php echo $stifel['active_listening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $stifel['cmt9'] ?>" disabled></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Professionalism</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[parallel_conversion]" disabled>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $stifel['parallel_conversion'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=5 <?php echo $stifel['parallel_conversion'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $stifel['parallel_conversion'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $stifel['cmt10'] ?>" disabled></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Resolution Accuracy</td>
										<td colspan=2 style="color:red">Issue Identification / Understanding</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points business" id="stag_hen_AF1" name="data[issue_identification]" disabled>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['issue_identification'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['issue_identification'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['issue_identification'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $stifel['cmt11'] ?>" disabled></td>
										<td>Business Critical</td>
									</tr>
						<!-- 			<tr>
										<td colspan=2>Probing</td>
										<td>
											<select class="form-control jurry_points customer" name="data[probing]" disabled>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['probing'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['probing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $stifel['cmt12'] ?>" disabled></td>
									</tr> -->
									<tr>
										<td colspan=2 style="color:red">False Commitment(Correct and Accurate Information)</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points business" id="stag_hen_AF2" name="data[false_commitment]" disabled>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['false_commitment'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['false_commitment'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['false_commitment'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $stifel['cmt13'] ?>" disabled></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml">Verification</td>
										<td colspan=2 style="color:red">Verification process followed</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points compliance" id="stag_hen_AF3" name="data[verification_process_follow]" disabled>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['verification_process_follow'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['verification_process_follow'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['verification_process_follow'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $stifel['cmt14'] ?>" disabled></td>
										<td>Compliance Critical</td>
									</tr>
									<tr>
										<td class="eml">ZTP</td>
										<td colspan=2 style="color:red">Rudeness</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points customer" id="stag_hen_AF4" name="data[rudeness]" disabled>
												<option value="">-Select-</option>
												<option ji_val=0 <?php echo $stifel['rudeness'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $stifel['rudeness'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $stifel['cmt15'] ?>" disabled></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Call Avoidance</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF5" name="data[call_avoidance]" disabled>
												<option value="">-Select-</option>
												<option ji_val=2 <?php echo $stifel['call_avoidance'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option ji_val=2 <?php echo $stifel['call_avoidance'] == "No"?"selected":"";?> value="No">Yes</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $stifel['cmt16'] ?>" disabled></td>
										<td>Customer Critical</td>
									</tr>
									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned"></td><td>Earned:</td><td id="busiJiCisEarned"></td><td>Earned:</td><td id="complJiCisEarned"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible"></td><td>Possible:</td><td id="busiJiCisPossible"></td><td>Possible:</td><td id="complJiCisPossible"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="data[customer_score]" value="<?php echo $stifel['customer_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="data[business_score]" value="<?php echo $stifel['business_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="data[compliance_score]" value="<?php echo $stifel['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $stifel['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $stifel['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($stifel['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$stifel['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $stifel['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $stifel['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $stifel['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $stifel['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required=""><?php echo $stifel['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($stifel['entry_date'],72) == true){ ?>
											<tr>
												<?php if($stifel['agent_rvw_note']==''){ ?>
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
