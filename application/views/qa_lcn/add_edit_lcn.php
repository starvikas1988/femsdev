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

<?php if($lcn_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">LCN Call Audit Sheet</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($lcn_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											//$month=date("F");
											$week="Week".$controller->weekOfMonth(date("Y-m-d"));
										}else{
											if($lcn['entry_by']!=''){
												$auditorName = $lcn['auditor_name'];
											}else{
												$auditorName = $lcn['client_name'];
											}
											$auditDate = mysql2mmddyy($lcn['audit_date']);
											$clDate_val = mysql2mmddyy($lcn['call_date']);
										//	$month= $lcn['Month'];
											$week= $lcn['week'];
										}
									?>
									
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
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
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $lcn['call_duration'] ?>" required></td>
									
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
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
										<td><input type="text" class="form-control" name=data[recording_id] value="<?php echo $lcn['recording_id']	; ?>" required ></td>
										<td>Tenure:</td>
										<td><input type="text" class="form-control" name=data[tenure] value="<?php echo $lcn['tenure']	; ?>" required ></td>
									<td>Fatal Error:</td>
										<td>
										<select class="form-control" id="fatal_error" name="data[fatal_error]" required>
											<option value="">-Select-</option>
											<option <?php echo $lcn['fatal_error']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											<option <?php echo $lcn['fatal_error']=='No'?"selected":""; ?> value="No">No</option>
										</select>
										</td>
									</tr>
									<tr>	
									<td>Week:</td>
										<td>
											<input type="text" name="data[week]" readonly class="form-control" value="<?php echo $week ?>" />
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
											<select class="form-control" id="voc" name="data[voc]" required>
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
											<select class="form-control cholamandlam_points"  name="data[appropriate_greeting]" required>
												<option cholamandlam_val=4 <?php echo $lcn['appropriate_greeting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $lcn['appropriate_greeting'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['appropriate_greeting'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><textarea name="data[cmt1]" class="form-control"><?php echo $lcn['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >b. Clear and Crisp opening</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[crisp_opening]" required>
												<option cholamandlam_val=4 <?php echo $lcn['crisp_opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $lcn['crisp_opening'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['crisp_opening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt2]" class="form-control"><?php echo $lcn['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >c. Purpose of the call</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[call_purpose]" required>
												<option cholamandlam_val=4 <?php echo $lcn['call_purpose'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												 <option cholamandlam_val=4 <?php echo $lcn['call_purpose'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['call_purpose'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><textarea name="data[cmt3]" class="form-control"><?php echo $lcn['cmt3'] ?></textarea></td>
									</tr>
									<tr>
																		
									<tr>
										<td class="eml" rowspan="9">Communication</td>
										<td colspan=2 >a. Voice modulation</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"   name="data[voice_modulation]" required>
												<option cholamandlam_val=3 <?php echo $lcn['voice_modulation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['voice_modulation'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['voice_modulation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt4]" class="form-control"><?php echo $lcn['cmt4'] ?></textarea></td>
									</tr>
									<td colspan=2 >b. Appropriate pace/Clarity of Speech</td>
									<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[appropriate_pace]" required>
												<option cholamandlam_val=3 <?php echo $lcn['appropriate_pace'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['appropriate_pace'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['appropriate_pace'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt5]" class="form-control"><?php echo $lcn['cmt5'] ?></textarea></td>
									</tr>
									
									<tr>
									<td colspan=2 >c. Courteous and professional</td>
									<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[professional]" required>
												<option cholamandlam_val=3 <?php echo $lcn['professional'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												 <option cholamandlam_val=3 <?php echo $lcn['professional'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['professional'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt6]" class="form-control"><?php echo $lcn['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >d. Call Etiquette</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"   name="data[call_empathy]" required>
												<option cholamandlam_val=3 <?php echo $lcn['call_empathy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['call_empathy'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['call_empathy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt7]" class="form-control"><?php echo $lcn['cmt7'] ?></textarea></td>
									</tr>

									<tr>
										<td colspan=2 >e. Adjusted to customer language</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[customer_language]" required>
												<option cholamandlam_val=3 <?php echo $lcn['customer_language'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['customer_language'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['customer_language'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt8]" class="form-control"><?php echo $lcn['cmt8'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 >f. No jargons - simple words used</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[jargons]" required>
												<option cholamandlam_val=3 <?php echo $lcn['jargons'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['jargons'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['jargons'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt9]" class="form-control"><?php echo $lcn['cmt9'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 >g. Active listening / Attentiveness</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[attentiveness]" required>
												<option cholamandlam_val=3 <?php echo $lcn['attentiveness'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['attentiveness'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['attentiveness'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt10]" class="form-control"><?php echo $lcn['cmt10'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 >h. Paraprashing</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[paraprashing]" required>
												<option cholamandlam_val=3 <?php echo $lcn['paraprashing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['paraprashing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['paraprashing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt11]" class="form-control"><?php echo $lcn['cmt11'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 >i. Grammatically correct sentences & Avoid fumbling & Fillers</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points"  name="data[fumbling_fillers]" required>
												<option cholamandlam_val=3 <?php echo $lcn['fumbling_fillers'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['fumbling_fillers'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['fumbling_fillers'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt12]" class="form-control"><?php echo $lcn['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" rowspan="4">Technical aspects</td>
										<td colspan=2>a. Appropriate Probing</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[appropriate_probing]" required>
												<option cholamandlam_val=3 <?php echo $lcn['appropriate_probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['appropriate_probing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['appropriate_probing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt13]" class="form-control"><?php echo $lcn['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Transfer whenever required</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[transfer]" required>
												<option cholamandlam_val=3 <?php echo $lcn['transfer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['transfer'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['transfer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt14]" class="form-control"><?php echo $lcn['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>c. Call control</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[call_control]" required>
												<option cholamandlam_val=3 <?php echo $lcn['call_control'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['call_control'] == "No"?"selected":"";?> value="No">No</option> 
												<option cholamandlam_val=0 <?php echo $lcn['call_control'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt15]" class="form-control"><?php echo $lcn['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>d. Proper rebuttals used</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[rebuttals_used]" required>
												<option cholamandlam_val=3 <?php echo $lcn['rebuttals_used'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['rebuttals_used'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['rebuttals_used'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt16]" class="form-control"><?php echo $lcn['cmt16'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="2">ACA</td>
										<td colspan=2>a. Proper qualification questions</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[qualification]" required>
												<option cholamandlam_val=3 <?php echo $lcn['qualification'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['qualification'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['qualification'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt17]" class="form-control"><?php echo $lcn['cmt17'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Proper call transfer</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[call_transfer]" required>
												<option cholamandlam_val=3 <?php echo $lcn['call_transfer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['call_transfer'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['call_transfer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt18]" class="form-control"><?php echo $lcn['cmt18'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="2">Documentation</td>
										<td colspan=2>a. Correct dispostion</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[correct_dispostion]" required>
												<option cholamandlam_val=3 <?php echo $lcn['correct_dispostion'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['correct_dispostion'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['correct_dispostion'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt19]" class="form-control"><?php echo $lcn['cmt19'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Proper data collection(Email/DOB)</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[update_asm]" required>
												<option cholamandlam_val=3 <?php echo $lcn['update_asm'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['update_asm'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['update_asm'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt20]" class="form-control"><?php echo $lcn['cmt20'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="3">Hold Protocol</td>
										<td colspan=2>a. Was Hold Required</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[required_hold]" required>
												<option cholamandlam_val=3 <?php echo $lcn['required_hold'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['required_hold'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['required_hold'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt21]" class="form-control"><?php echo $lcn['cmt21'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Hold Guidelines followed</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[guidelines_hold]" required>
												<option cholamandlam_val=3 <?php echo $lcn['guidelines_hold'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['guidelines_hold'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['guidelines_hold'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt22]" class="form-control"><?php echo $lcn['cmt22'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>c. Dead Air <= 8 seconds</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[dead_air]" required>
												<option cholamandlam_val=3 <?php echo $lcn['dead_air'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['dead_air'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['dead_air'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt23]" class="form-control"><?php echo $lcn['cmt23'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="3">Call Closing</td>
										<td colspan=2>a. Further assistance</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[assistance]" required>
												<option cholamandlam_val=3 <?php echo $lcn['assistance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['assistance'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['assistance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt24]" class="form-control"><?php echo $lcn['cmt24'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>b. Hot transfer</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[experience]" required>
												<option cholamandlam_val=3 <?php echo $lcn['experience'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['experience'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['experience'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt25]" class="form-control"><?php echo $lcn['cmt25'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>c. Adherence to call closing script</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[call_closing]" required>
												<option cholamandlam_val=3 <?php echo $lcn['call_closing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['call_closing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['call_closing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt26]" class="form-control"><?php echo $lcn['cmt26'] ?></textarea></td>
									</tr>
									<tr>
									<td class="eml" rowspan="4" style="color:#FF0000">Fatal Parameters</td>
										<td colspan=2 style="color:#FF0000">a. Delayed opening</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF1" name="data[delayed_opening]" required>
												<option cholamandlam_val=4 <?php echo $lcn['delayed_opening'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option cholamandlam_val=4 <?php echo $lcn['delayed_opening'] == "No"?"selected":"";?> value="No">Yes</option>
												
												<option cholamandlam_val=4 <?php echo $lcn['delayed_opening'] == "N/AA"?"selected":"";?> value="N/AA">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt27]" class="form-control"><?php echo $lcn['cmt27'] ?></textarea></td>
									</tr>										
									
									<tr>
									<td colspan=2 style="color:#FF0000">b. Rude on call</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF2" name="data[rude_call]" required>
												<option cholamandlam_val=4 <?php echo $lcn['rude_call'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option cholamandlam_val=4 <?php echo $lcn['rude_call'] == "No"?"selected":"";?> value="No">Yes</option>
												
												<option cholamandlam_val=4 <?php echo $lcn['rude_call'] == "N/AA"?"selected":"";?> value="N/AA">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt28]" class="form-control"><?php echo $lcn['cmt28'] ?></textarea></td>
									</tr>	
									<tr>
									<td colspan=2 style="color:#FF0000">c. Incomplete/Inaccurate Information shared</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF3" name="data[information]" required>
												<option cholamandlam_val=4 <?php echo $lcn['information'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option cholamandlam_val=4 <?php echo $lcn['information'] == "No"?"selected":"";?> value="No">Yes</option>
												
												<option cholamandlam_val=4 <?php echo $lcn['information'] == "N/AA"?"selected":"";?> value="N/AA">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt29]" class="form-control"><?php echo $lcn['cmt29'] ?></textarea></td>
									</tr>	
									<tr>
									<td colspan=2 style="color:#FF0000">d. Work Avoidance</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF4" name="data[work_avoidance]" required>
												<option cholamandlam_val=4 <?php echo $lcn['work_avoidance'] == "Yes"?"selected":"";?> value="Yes">No</option>
												<option cholamandlam_val=4 <?php echo $lcn['work_avoidance'] == "No"?"selected":"";?> value="No">Yes</option>
												
												<option cholamandlam_val=4 <?php echo $lcn['work_avoidance'] == "N/AA"?"selected":"";?> value="N/AA">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt30]" class="form-control"><?php echo $lcn['cmt30'] ?></textarea></td>
									</tr>	
									<tr>
									<td class="eml">New Terminology Implementation</td>
										<td colspan=2>a. Used "Applicant" instead of "Customer"</td>
										<td>3</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[instead_customer]" required>
												<option cholamandlam_val=3 <?php echo $lcn['instead_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=3 <?php echo $lcn['instead_customer'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $lcn['instead_customer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td  colspan=2><textarea name="data[cmt31]" class="form-control"><?php echo $lcn['cmt31'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $lcn['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $lcn['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($lcn_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($lcn['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$lcn['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_lcn/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_lcn/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($lcn_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $lcn['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $lcn['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $lcn['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $lcn['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($lcn_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($lcn['entry_date'],72) == true){ ?>
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
					
				  </form>
					
				</div>
			</div>
		</div>

	</section>
</div>
