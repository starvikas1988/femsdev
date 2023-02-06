
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
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">LCN Call Audit</td></tr>
									<?php
										if($lcn_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											// $month=date("F");
											// $week="Week".$controller->weekOfMonth(date("Y-m-d"));
										}else{
											if($lcn['entry_by']!=''){
												$auditorName = $lcn['auditor_name'];
											}else{
												$auditorName = $lcn['client_name'];
											}
											$auditDate = mysql2mmddyy($lcn['audit_date']);
											$clDate_val = mysql2mmddyy($lcn['call_date']);
											//  $month= $lcn['Month'];
											//  $week= $lcn['Week'];
										}
									?>
									
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
												<option value="<?php echo $lcn['agent_id'] ?>"><?php echo $lcn['fname']." ".$lcn['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $lcn['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $lcn['tl_id'] ?>"><?php echo $lcn['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $lcn['call_duration'] ?>" disabled></td>
									
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
											<option value="<?php echo $lcn['audit_type'] ?>"><?php echo $lcn['audit_type'] ?></option>	
											<option value="">-Select-</option>
											<option <?php echo $lcn['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $lcn['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $lcn['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
											<option <?php echo $lcn['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $lcn['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
											<option value="<?php echo $lcn['auditor_type'] ?>"><?php echo $lcn['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										
									</tr>
								
									<tr>
									<td>Recording ID:</td>
										<td><input type="text" class="form-control" name=data[recording_id] value="<?php echo $lcn['recording_id']	; ?>" disabled ></td>
										<td>Tenure:</td>
										<td><input type="text" class="form-control" name=data[tenure] value="<?php echo $lcn['tenure']	; ?>" disabled ></td>
									<td>Fatal Error:</td>
										<td>
										<select class="form-control" id="fatal_error" name="data[fatal_error]" disabled>
											<option value="">-Select-</option>
											<option <?php echo $lcn['fatal_error']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											<option <?php echo $lcn['fatal_error']=='No'?"selected":""; ?> value="No">No</option>
										</select>
										</td>
									</tr>
									<tr>	
									<td>Week:</td>
										<td>
											<input type="text" name="data[week]" readonly class="form-control" value="<?php echo $lcn['week']; ?>" />
											<!-- <select class="form-control" name="data[Week]" required>
												<option value="<?php //echo $lcn['Week'] ?>"><?php //echo $lcn['Week'] ?></option>
												<option value="">-Select-</option>
												<option value="Week1">Week1</option>
												<option value="Week2">Week2</option>
												<option value="Week3">Week3</option>
												<option value="Week4">Week4</option>
												<option value="Week5">Week5</option>	
											</select> -->
										</td>
									<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="<?php echo $lcn['voc'] ?>"><?php echo $lcn['voc'] ?></option>
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
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="cholamandlam_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $lcn['possible_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="cholamandlam_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $lcn['earned_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="cholamandlam_overallScore" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $lcn['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D2B4DE">
										<td>PARAMETER</td>
										<td colspan=2>SUB PARAMETER</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Opening</td>
										<td colspan=2 > a. Appropriate greeting - as per script</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[appropriate_greeting]" disabled>
												<option cholamandlam_val=4 <?php echo $lcn['appropriate_greeting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $lcn['appropriate_greeting'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['appropriate_greeting'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><textarea name="data[cmt1]" disabled class="form-control"><?php echo $lcn['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >b. Clear and Crisp opening</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[crisp_opening]" disabled>
												<option cholamandlam_val=4 <?php echo $lcn['crisp_opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $lcn['crisp_opening'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['crisp_opening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt2]" disabled class="form-control"><?php echo $lcn['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >c. Purpose of the call</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[call_purpose]" disabled>
												<option cholamandlam_val=4 <?php echo $lcn['call_purpose'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												 <option cholamandlam_val=4 <?php echo $lcn['call_purpose'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['call_purpose'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><textarea name="data[cmt3]" disabled class="form-control"><?php echo $lcn['cmt3'] ?></textarea></td>
									</tr>
									<tr>
																		
									<tr>
										<td class="eml" rowspan="9">Communication</td>
										<td colspan=2 >a. Voice modulation</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"   name="data[voice_modulation]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['voice_modulation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['voice_modulation'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['voice_modulation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt4]" disabled class="form-control"><?php echo $lcn['cmt4'] ?></textarea></td>
									</tr>
									<td colspan=2 >b. Appropriate pace/Clarity of Speech</td>
									<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[appropriate_pace]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['appropriate_pace'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['appropriate_pace'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['appropriate_pace'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt5]" disabled class="form-control"><?php echo $lcn['cmt5'] ?></textarea></td>
									</tr>
									
									<tr>
									<td colspan=2 >c. Courteous and professional</td>
									<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[professional]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['professional'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												 <option cholamandlam_val=3 <?php echo $lcn['professional'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['professional'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt6]" disabled class="form-control"><?php echo $lcn['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >d. Call Etiquette</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"   name="data[call_empathy]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['call_empathy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['call_empathy'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['call_empathy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt7]" disabled class="form-control"><?php echo $lcn['cmt7'] ?></textarea></td>
									</tr>

									<tr>
										<td colspan=2 >e. Adjusted to customer language</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[customer_language]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['customer_language'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['customer_language'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['customer_language'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt8]" disabled class="form-control"><?php echo $lcn['cmt8'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 >f. No jargons - simple words used</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[jargons]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['jargons'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['jargons'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['jargons'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt9]" disabled class="form-control"><?php echo $lcn['cmt9'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 >g. Active listening / Attentiveness</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[attentiveness]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['attentiveness'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['attentiveness'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['attentiveness'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt10]" disabled class="form-control"><?php echo $lcn['cmt10'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 >h. Paraprashing</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[paraprashing]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['paraprashing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['paraprashing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['paraprashing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt11]" disabled class="form-control"><?php echo $lcn['cmt11'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 >i. Grammatically correct sentences & Avoid fumbling & Fillers</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[fumbling_fillers]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['fumbling_fillers'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['fumbling_fillers'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['fumbling_fillers'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt12]" disabled class="form-control"><?php echo $lcn['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" rowspan="4">Technical aspects</td>
										<td colspan=2>a. Appropriate Probing</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[appropriate_probing]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['appropriate_probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['appropriate_probing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['appropriate_probing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt13]" disabled class="form-control"><?php echo $lcn['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Transfer whenever required</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[transfer]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['transfer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['transfer'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['transfer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt14]" disabled class="form-control"><?php echo $lcn['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>c.Call control</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[call_control]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['call_control'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['call_control'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['call_control'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt15]" disabled class="form-control"><?php echo $lcn['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>d. Proper rebuttals used</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[rebuttals_used]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['rebuttals_used'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['rebuttals_used'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['rebuttals_used'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt16]" disabled class="form-control"><?php echo $lcn['cmt16'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="2">ACA</td>
										<td colspan=2>a. Proper qualification questions</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[qualification]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['qualification'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['qualification'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['qualification'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt17]" disabled class="form-control"><?php echo $lcn['cmt17'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Proper call transfer</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[call_transfer]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['call_transfer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['call_transfer'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['call_transfer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt18]" disabled class="form-control"><?php echo $lcn['cmt18'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="2">Documentation</td>
										<td colspan=2>a. Correct dispostion</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[correct_dispostion]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['correct_dispostion'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['correct_dispostion'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['correct_dispostion'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt19]" disabled class="form-control"><?php echo $lcn['cmt19'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Proper data collection(Email/DOB)</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[update_asm]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['update_asm'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['update_asm'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['update_asm'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt20]" disabled class="form-control"><?php echo $lcn['cmt20'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="3">Hold Protocol</td>
										<td colspan=2>a. Was Hold Required</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[required_hold]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['required_hold'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['required_hold'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['required_hold'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt21]" disabled class="form-control"><?php echo $lcn['cmt21'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Hold Guidelines followed</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[guidelines_hold]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['guidelines_hold'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['guidelines_hold'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['guidelines_hold'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt22]" disabled class="form-control"><?php echo $lcn['cmt22'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>c. Dead Air <= 8 seconds</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[dead_air]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['dead_air'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['dead_air'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['dead_air'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt23]" disabled class="form-control"><?php echo $lcn['cmt23'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="3">Call Closing</td>
										<td colspan=2>a. Further assistance</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[assistance]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['assistance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['assistance'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['assistance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt24]" disabled class="form-control"><?php echo $lcn['cmt24'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Hot transfer</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[experience]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['experience'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['experience'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['experience'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt25]" disabled class="form-control"><?php echo $lcn['cmt25'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>c. Adherence to call closing script</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[call_closing]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['call_closing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['call_closing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['call_closing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt26]" disabled class="form-control"><?php echo $lcn['cmt26'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="4" style="color:#FF0000">Fatal Parameters</td>
										<td colspan=2 style="color:#FF0000">a. Delayed opening</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF1" name="data[delayed_opening]" disabled>
											<!-- 	<option cholamandlam_val=4 <?php //echo $lcn['delayed_opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php //echo $lcn['delayed_opening'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php //echo $lcn['delayed_opening'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->

												<option cholamandlam_val=4 <?php echo $lcn['delayed_opening'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option cholamandlam_val=4 <?php echo $lcn['delayed_opening'] == "No"?"selected":"";?> value="No">Yes</option>
												
												<option cholamandlam_val=4 <?php echo $lcn['delayed_opening'] == "N/AA"?"selected":"";?> value="N/AA">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt27]" disabled class="form-control"><?php echo $lcn['cmt27'] ?></textarea></td>
									</tr>										
									
									<tr>
									<td colspan=2 style="color:#FF0000">b. Rude on call</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF2" name="data[rude_call]" disabled>
											<!-- 	<option cholamandlam_val=4 <?php //echo $lcn['rude_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php //echo $lcn['rude_call'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php //echo $lcn['rude_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
												<option cholamandlam_val=4 <?php echo $lcn['rude_call'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option cholamandlam_val=4 <?php echo $lcn['rude_call'] == "No"?"selected":"";?> value="No">Yes</option>
												
												<option cholamandlam_val=4 <?php echo $lcn['rude_call'] == "N/AA"?"selected":"";?> value="N/AA">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt28]" disabled class="form-control"><?php echo $lcn['cmt28'] ?></textarea></td>
									</tr>	
									<tr>
									<td colspan=2 style="color:#FF0000">c. Incomplete/Inaccurate Information shared</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF3" name="data[information]" disabled>
											<!-- 	<option cholamandlam_val=4 <?php //echo $lcn['information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php //echo $lcn['information'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php //echo $lcn['information'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
												<option cholamandlam_val=4 <?php echo $lcn['information'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option cholamandlam_val=4 <?php echo $lcn['information'] == "No"?"selected":"";?> value="No">Yes</option>
												
												<option cholamandlam_val=4 <?php echo $lcn['information'] == "N/AA"?"selected":"";?> value="N/AA">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt29]" disabled class="form-control"><?php echo $lcn['cmt29'] ?></textarea></td>
									</tr>	
									<tr>
									<td colspan=2 style="color:#FF0000">d. Work Avoidance</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF4" name="data[work_avoidance]" disabled>
												<!-- <option cholamandlam_val=4 <?php //echo $lcn['work_avoidance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php //echo $lcn['work_avoidance'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php //echo $lcn['work_avoidance'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
												<option cholamandlam_val=4 <?php echo $lcn['work_avoidance'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option cholamandlam_val=4 <?php echo $lcn['work_avoidance'] == "No"?"selected":"";?> value="No">Yes</option>
												
												<option cholamandlam_val=4 <?php echo $lcn['work_avoidance'] == "N/AA"?"selected":"";?> value="N/AA">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt30]" disabled class="form-control"><?php echo $lcn['cmt30'] ?></textarea></td>
									</tr>	
									<tr>
									<td class="eml">New Terminology Implementation</td>
										<td colspan=2>a. Used "Applicant" instead of "Customer"</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[instead_customer]" disabled>
												<option cholamandlam_val=3 <?php echo $lcn['instead_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['instead_customer'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['instead_customer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt31]" disabled class="form-control"><?php echo $lcn['cmt31'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $lcn['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $lcn['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($lcn['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$lcn['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_lcn/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_lcn/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $lcn['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $lcn['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $lcn['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $lcn['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $lcn['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($lcn['entry_date'],72) == true){ ?>
											<tr>
												<?php if($lcn['agent_rvw_note']==''){ ?>
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
