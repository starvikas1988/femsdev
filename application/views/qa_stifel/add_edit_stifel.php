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
}

</style>

<?php if($stifel_id!=0){
if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
		}
	</style>
<?php } 
} ?>

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
										<td colspan="9" id="theader" style="font-size:40px">Stifel Scorecard</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($stifel_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($stifel['entry_by']!=''){
												$auditorName = $stifel['auditor_name'];
											}else{
												$auditorName = $stifel['client_name'];
											}
											$auditDate = mysql2mmddyy($stifel['audit_date']);
											$clDate_val = mysqlDt2mmddyy($stifel['call_date']);
										}
									?>
									<tr>
										<td style="width:130px;">Auditor Name:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td >Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:100px;">Call Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td style="width:130px;">Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $stifel['agent_id'] ?>"><?php echo $stifel['fname']." ".$stifel['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td >Fusion ID:</td>
										<td colspan="2"><input type="text" class="form-control" id="fusion_id" value="<?php echo $stifel['fusion_id'] ?>" readonly ></td>
										<td style="width:100px;">L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $stifel['tl_id'] ?>"><?php echo $stifel['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td style="width:130px;">Call Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $stifel['call_duration'] ?>" required></td>
										<td>Hold Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="hold_duration" name="data[hold_duration]" value="<?php echo $stifel['hold_duration'] ?>" required></td>
										<td style="width:100px;">Verification Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="verification_duration" name="data[verification_duration]" value="<?php echo $stifel['verification_duration'] ?>" required></td>
									</tr>
									<tr>
										<td style="width:130px;">Interaction ID:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[interaction_id]" value="<?php echo $stifel['interaction_id'] ?>" required></td>
									
										<td>Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $stifel['audit_type'] ?>"><?php echo $stifel['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
											</select>
										</td>
										<td class="auType" style="width: 100px;">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $stifel['voc'] ?>"><?php echo $stifel['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td colspan="2"><input type="text" value="<?= $stifel['earned_score']?>" readonly id="jurys_inn_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td colspan="2"><input type="text" value="<?= $stifel['possible_score']?>" readonly id="jurys_inn_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="jurys_inn_overall_score" name="data[overall_score]" class="form-control stifel_fatal" style="font-weight:bold" value="<?php echo $stifel['overall_score'] ?>"></td>
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
											<select class="form-control jurry_points customer" name="data[opening]" required>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['opening'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['opening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $stifel['cmt1'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Closing</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[closing]" required>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['closing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['closing'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['closing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $stifel['cmt3'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Empathy and Ownership</td>
										<td colspan=2>Empathy / Apology</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[empathy_apology]" required>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['empathy_apology'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['empathy_apology'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['empathy_apology'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $stifel['cmt4'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Ownership / Assurance</td>
										<td>9</td>
										<td>
											<select class="form-control jurry_points customer" name="data[owenship_assurance]" required>
												<option value="">-Select-</option>
												<option ji_val=9 <?php echo $stifel['owenship_assurance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=9 <?php echo $stifel['owenship_assurance'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=9 <?php echo $stifel['owenship_assurance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $stifel['cmt5'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Hold and Escalation Protocol</td>
										<td colspan=2>Call Control</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[hold_protocol]" required>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['hold_protocol'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['hold_protocol'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['hold_protocol'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $stifel['cmt6'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Transfer</td>
										<td>9</td>
										<td>
											<select class="form-control jurry_points business" name="data[transfer]" required>
												<option value="">-Select-</option>
												<option ji_val=9 <?php echo $stifel['transfer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=9 <?php echo $stifel['transfer'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=9 <?php echo $stifel['transfer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $stifel['cmt7'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Effective Communication</td>
										<td colspan=2>Tone / Rate Of Speech / Fumbling/Pacing</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[rate_of_speech]" required>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['rate_of_speech'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['rate_of_speech'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['rate_of_speech'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $stifel['cmt8'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Active Listening</td>
										<td>9</td>
										<td>
											<select class="form-control jurry_points customer" name="data[active_listening]" required>
												<option value="">-Select-</option>
												<option ji_val=9 <?php echo $stifel['active_listening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=9 <?php echo $stifel['active_listening'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=9 <?php echo $stifel['active_listening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $stifel['cmt9'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Professionalism</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[parallel_conversion]" required>
												<option value="">-Select-</option>
												<option ji_val=10 <?php echo $stifel['parallel_conversion'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=10 <?php echo $stifel['parallel_conversion'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=10 <?php echo $stifel['parallel_conversion'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $stifel['cmt10'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Resolution Accuracy</td>
										<td colspan=2 style="color:red">Issue Identification / Understanding</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points business" id="stifel_AF1" name="data[issue_identification]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $stifel['issue_identification'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $stifel['issue_identification'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=3 <?php echo $stifel['issue_identification'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $stifel['cmt11'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">False Commitment(Correct and Accurate Information)</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points business" id="stifel_AF2" name="data[false_commitment]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $stifel['false_commitment'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option ji_val=3 <?php echo $stifel['false_commitment'] == "No"?"selected":"";?> value="No">Yes</option>
												<option ji_val=3 <?php echo $stifel['false_commitment'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $stifel['cmt13'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml">Verification</td>
										<td colspan=2 style="color:red">Verification process followed</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points compliance" id="stifel_AF3" name="data[verification_process_follow]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $stifel['verification_process_follow'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $stifel['verification_process_follow'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=3 <?php echo $stifel['verification_process_follow'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $stifel['cmt14'] ?>"></td>
										<td>Compliance Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2 >ZTP</td>
										<td colspan=2 style="color:red">Rudeness</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF5" name="data[rudeness]" required>
												<option value="">-Select-</option>
												<option ji_val=2 <?php echo $stifel['rudeness'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option ji_val=2 <?php echo $stifel['rudeness'] == "No"?"selected":"";?> value="No">Yes</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $stifel['cmt15'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Call Avoidance</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF6" name="data[call_avoidance]" required>
												<option value="">-Select-</option>
												<option ji_val=2 <?php echo $stifel['call_avoidance'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option ji_val=2 <?php echo $stifel['call_avoidance'] == "No"?"selected":"";?> value="No">Yes</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $stifel['cmt16'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr style="background-color:#D2B4DE"><td colspan="3">Customer Score</td><td colspan="3">Business Score</td><td colspan="3">Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned" colspan="2"></td><td>Earned:</td><td id="busiJiCisEarned" colspan="2"></td><td>Earned:</td><td id="complJiCisEarned" colspan="2"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible" colspan="2"></td><td>Possible:</td><td id="busiJiCisPossible" colspan="2"></td><td>Possible:</td><td id="complJiCisPossible" colspan="2"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="data[customer_score]" value="<?php echo $stifel['customer_score'] ?>"></td>
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="data[business_score]" value="<?php echo $stifel['business_score'] ?>"></td>
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="data[compliance_score]" value="<?php echo $stifel['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="3"><textarea class="form-control" name="data[call_summary]"><?php echo $stifel['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="3"><textarea class="form-control" name="data[feedback]"><?php echo $stifel['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($stifel_id==0){ ?>
											<td colspan="7"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" style="padding-top: 10px;"></td>
										<?php }else{
											if($stifel['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$stifel['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($stifel_id!=0){ ?>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=5><?php echo $stifel['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=5><?php echo $stifel['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=5><?php echo $stifel['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=5><?php echo $stifel['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=4  style="font-size:16px">Your Review</td><td colspan=5><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($stifel_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan="9"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($stifel['entry_date'],72) == true){ ?>
												<tr><td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
									<?php 	
											}
										}
									} 
									?>
									
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
