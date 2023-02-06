
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
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">Cholamandlam</td></tr>
									<?php
										if($cholamandlam_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($cholamandlam['entry_by']!=''){
												$auditorName = $cholamandlam['auditor_name'];
											}else{
												$auditorName = $cholamandlam['client_name'];
											}
											$auditDate = mysql2mmddyy($cholamandlam['audit_date']);
											$clDate_val = mysql2mmddyy($cholamandlam['call_date']);
										}
									?>
								
									<tr>
										<td>Auditor Name:</td>
										<?php if($cholamandlam['entry_by']!=''){
												$auditorName = $cholamandlam['auditor_name'];
											}else{
												$auditorName = $cholamandlam['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($cholamandlam['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($cholamandlam['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $cholamandlam['fname']." ".$cholamandlam['lname']." - [".$cholamandlam['fusion_id']."]" ?></option>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td><select class="form-control" disabled><option><?php echo $cholamandlam['tl_name'] ?></option></select></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control"  value="<?php echo $cholamandlam['call_duration'] ?>" disabled></td>
									
									</tr>
									<tr>
									<td>Track ID:</td>
										<td><input type="text" class="form-control"  value="<?php echo $cholamandlam['track_id']	; ?>" disabled ></td>
									<td>Mobile No:</td>
										<td><input type="text" class="form-control" name=data[mobile_no] value="<?php echo $cholamandlam['mobile_no']; ?>" disabled></td>	
									<td>Language:</td>
										<td><input type="text" class="form-control" name=data[language] value="<?php echo $cholamandlam['language']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $cholamandlam['audit_type'] ?></option></select></td>
										<td>Week</td>
										<td>
										<select class="form-control"  name="data[week]" disabled>
											<option value="<?php echo $cholamandlam['week'] ?>"><?php echo $cholamandlam['week'] ?></option>
										</select>
									</td>	
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $cholamandlam['voc'] ?></option></select></td>
										
									</tr>
									<tr>
									<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" class="form-control" style="font-weight:bold" value="<?php echo $cholamandlam['overall_score'] ?>" disabled></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D2B4DE">
										<td>PARAMETER</td>
										<td colspan=2>SUB PARAMETER</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td class="eml" rowspan=5>Business Critical</td>
										<td colspan=2 style="color:#FF0000">Objection Handling</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[objection_handling]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['objection_handling'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
											<!-- 	<option cholamandlam_val=4 <?php //echo $cholamandlam['objection_handling'] == "No"?"selected":"";?> value="No">No</option> -->
											<option cholamandlam_val=0 <?php echo $cholamandlam['objection_handling'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
										<td rowspan=5 colspan=2><textarea name="data[business_critical_comment]" class="form-control" disabled><?php echo $cholamandlam['business_critical_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Disposition</td>
										<td>4</td>
										<td>
											<select class="form-control disposition"  name="data[disposition]" disabled>
												<option value="">-Select-</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['disposition'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
											<!-- 	<option cholamandlam_val=4 <?php //echo $cholamandlam['disposition'] == "No"?"selected":"";?> value="No">No</option> -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['disposition'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Verification</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[verification]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['verification'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!--  <option cholamandlam_val=4 <?php //echo $cholamandlam['verification'] == "No"?"selected":"";?> value="No">No</option>  -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['verification'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
									</tr>
									<tr>
									<td colspan=2 style="color:#FF0000">Follow up (Lead/ Call back/ Email)</td>
									<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[follow_up]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['follow_up'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option cholamandlam_val=4 <?php //echo $cholamandlam['follow_up'] == "No"?"selected":"";?> value="No">No</option> -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['follow_up'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
									</tr>
									
									<tr>
									<td colspan=2 style="color:#FF0000">Uphold Company Image</td>
									<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[uphold_company]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['uphold_company'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!--  <option cholamandlam_val=4 <?php //echo $cholamandlam['uphold_company'] == "No"?"selected":"";?> value="No">No</option> -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['uphold_company'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Customer Critical</td>
										<td colspan=2 style="color:#FF0000">Customer Centricity & Professionalism</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[professionalism]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['professionalism'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
											<!-- 	<option cholamandlam_val=4 <?php //echo $cholamandlam['professionalism'] == "No"?"selected":"";?> value="No">No</option>  -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['professionalism'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
										<td rowspan=3 colspan=2><textarea name="data[customer_critical_comment]" class="form-control" disabled><?php echo $cholamandlam['customer_critical_comment'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 style="color:#FF0000">Politeness and Courtesy</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[politeness_courtesy]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['politeness_courtesy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
											<!-- 	<option cholamandlam_val=4 <?php //echo $cholamandlam['politeness_courtesy'] == "No"?"selected":"";?> value="No">No</option>  -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['politeness_courtesy'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Product /Process Knowledge (Complete and correct information)</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[process_knowledge]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['process_knowledge'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option cholamandlam_val=4 <?php //echo $cholamandlam['process_knowledge'] == "No"?"selected":"";?> value="No">No</option> -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['process_knowledge'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td class="eml" rowspan=15>Non-Critical</td>
										<td colspan=2>Opening Script</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[opening_script]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['opening_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['opening_script'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['opening_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td rowspan=15 colspan=2><textarea name="data[non_critical_comment]" class="form-control" disabled><?php echo $cholamandlam['non_critical_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Probing</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[probing]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam['probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam['probing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['probing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Clarity of Speech</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[clarity_speech]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['clarity_speech'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['clarity_speech'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $cholamandlam['clarity_speech'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Pace of Speech</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[pace_speech]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['pace_speech'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['pace_speech'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['pace_speech'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Interruption</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[interruption]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['interruption'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['interruption'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['interruption'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Active Listening and Attentiveness</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[active_listening]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['active_listening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['active_listening'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['active_listening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Telephone Etiquette/Signposting & Jargons</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[telephone_etiquette]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['telephone_etiquette'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['telephone_etiquette'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['telephone_etiquette'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Lack of Energy</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[lack_energy]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['lack_energy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['lack_energy'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['lack_energy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Empathy</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[empathy]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['empathy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['empathy'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['empathy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Hold procedure</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[hold_procedure]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['hold_procedure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['hold_procedure'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['hold_procedure'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Mute/Dead air</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[dead_air]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['dead_air'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['dead_air'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['dead_air'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Stammering</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[stammering]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['stammering'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['stammering'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['stammering'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Digital Pitch</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[digital_pitch]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam['digital_pitch'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam['digital_pitch'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['digital_pitch'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Sales Pitch & Effort on call</td>
										<td>10</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[sales_pitch]" disabled>
												<option cholamandlam_val=10 <?php echo $cholamandlam['sales_pitch'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=10 <?php echo $cholamandlam['sales_pitch'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['sales_pitch'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2>Closing script</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[closing_script]" disabled>
												<option cholamandlam_val=4 <?php echo $cholamandlam['closing_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['closing_script'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['closing_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Correct Disposition</td>
										<td><input type="text" class="form-control"  name="data[correct_disposition]" value="<?php echo $cholamandlam['correct_disposition'] ?>" disabled></td>
										<td>Disposition selected by agent</td>
										<td><input type="text" class="form-control"  name="data[disposition_agent]" value="<?php echo $cholamandlam['disposition_agent'] ?>" disabled></td>
										<td>Wrong Disposition -Failure Remarks</td>
										<td><input type="text" class="form-control"  name="data[failure_remarks]" value="<?php echo $cholamandlam['failure_remarks'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Maintain Professionalism - Failure Reason</td>
										<td><input type="text" class="form-control"  name="data[failure_reason]" value="<?php echo $cholamandlam['failure_reason'] ?>" disabled></td>
										<td>Standard call opening Adherence</td>
										<td><input type="text" class="form-control" disabled name="data[standard_call]" value="<?php echo $cholamandlam['standard_call'] ?>" disabled></td>
										<td>Pick up call validation</td>
										<td><input type="text" class="form-control" name="data[call_validation]" value="<?php echo $cholamandlam['call_validation'] ?>" disabled></td>
									<tr>
										<td>EMI Amount Confirmation</td>
										<td><input type="text" class="form-control" name="data[emi_amount]" value="<?php echo $cholamandlam['emi_amount'] ?>" disabled></td>
										<td>Address Confirmation</td>
										<td><input type="text" class="form-control" name="data[address]" value="<?php echo $cholamandlam['address'] ?>" disabled></td>
										<td>Invalid Pickup Remarks (If any)</td>
										<td><input type="text" class="form-control" name="data[pickup_remarks]" value="<?php echo $cholamandlam['pickup_remarks'] ?>" disabled></td>
									</tr>

								
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $cholamandlam['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $cholamandlam['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($cholamandlam['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$cholamandlam['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $cholamandlam['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $cholamandlam['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $cholamandlam['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $cholamandlam['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $cholamandlam['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($cholamandlam['entry_date'],72) == true){ ?>
											<tr>
												<?php if($cholamandlam['agent_rvw_note']==''){ ?>
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
