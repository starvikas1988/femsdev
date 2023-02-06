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

<?php if($cholamandlam_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">Cholamandlam</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
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
												<option value="<?php echo $cholamandlam['agent_id'] ?>"><?php echo $cholamandlam['fname']." ".$cholamandlam['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $cholamandlam['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $cholamandlam['tl_id'] ?>"><?php echo $cholamandlam['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $cholamandlam['call_duration'] ?>" required></td>
									
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
											<option value="<?php echo $cholamandlam['audit_type'] ?>"><?php echo $cholamandlam['audit_type'] ?></option>	
											<option value="">-Select-</option>
											<option <?php echo $cholamandlam['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $cholamandlam['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $cholamandlam['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
											<option <?php echo $cholamandlam['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $cholamandlam['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
											<option value="<?php echo $cholamandlam['auditor_type'] ?>"><?php echo $cholamandlam['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										
									</tr>
								
									<tr>
									<td>Track ID:</td>
										<td><input type="text" class="form-control" name=data[track_id] value="<?php echo $cholamandlam['track_id']	; ?>" required ></td>
									<td>Mobile No:</td>
										<td><input type="text" class="form-control" name=data[mobile_no] value="<?php echo $cholamandlam['mobile_no']; ?>" required></td>	
									<td>Language:</td>
										<td><input type="text" class="form-control" name=data[language] value="<?php echo $cholamandlam['language']; ?>" required></td>
									</tr>
									<tr>	
									<td>Week</td>
										<td>
										<select class="form-control"  name="data[week]" required>
											<option value="<?php echo $cholamandlam['week'] ?>"><?php echo $cholamandlam['week'] ?></option>
											<option value="">-Select-</option>
											<option value="Week1">Week1</option>
											<option value="Week2">Week2</option>
											<option value="Week3">Week3</option>
											<option value="Week4">Week4</option>
											<option value="Week5">Week5</option>
										</select>
									</td>	
									<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $cholamandlam['voc'] ?>"><?php echo $cholamandlam['voc'] ?></option>
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
										<td><input type="text" readonly id="cholamandlam_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $cholamandlam['possible_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="cholamandlam_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $cholamandlam['earned_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="cholamandlam_overallScore" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $cholamandlam['overall_score'] ?>"></td>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF1" name="data[objection_handling]" required>
												<option cholamandlam_val=4 <?php echo $cholamandlam['objection_handling'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option cholamandlam_val=4 <?php //echo $cholamandlam['objection_handling'] == "No"?"selected":"";?> value="No">No</option> -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['objection_handling'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
										<td rowspan=5 colspan=2><textarea name="data[business_critical_comment]" class="form-control"><?php echo $cholamandlam['business_critical_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Disposition</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF2" name="data[disposition]" required>
												<option cholamandlam_val=4 <?php echo $cholamandlam['disposition'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option cholamandlam_val=4 <?php //echo $cholamandlam['disposition'] == "No"?"selected":"";?> value="No">No</option>  -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['disposition'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Verification</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF3" name="data[verification]" required>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF4" name="data[follow_up]" required>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF5" name="data[uphold_company]" required>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF6"  name="data[professionalism]" required>
												<option cholamandlam_val=4 <?php echo $cholamandlam['professionalism'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option cholamandlam_val=4 <?php //echo $cholamandlam['professionalism'] == "No"?"selected":"";?> value="No">No</option>  -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['professionalism'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
										<td rowspan=3 colspan=2><textarea name="data[customer_critical_comment]" class="form-control"><?php echo $cholamandlam['customer_critical_comment'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2 style="color:#FF0000">Politeness and Courtesy</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF7"  name="data[politeness_courtesy]" required>
												<option cholamandlam_val=4 <?php echo $cholamandlam['politeness_courtesy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option cholamandlam_val=4 <?php //echo $cholamandlam['politeness_courtesy'] == "No"?"selected":"";?> value="No">No</option>  -->
												<option cholamandlam_val=0 <?php echo $cholamandlam['politeness_courtesy'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:#FF0000">Product /Process Knowledge (Complete and correct information)</td>
										<td>4</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF8" name="data[process_knowledge]" required>
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
											<select class="form-control cholamandlam_points" name="data[opening_script]" required>
												<option cholamandlam_val=4 <?php echo $cholamandlam['opening_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['opening_script'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['opening_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td rowspan=15 colspan=2><textarea name="data[non_critical_comment]" class="form-control"><?php echo $cholamandlam['non_critical_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Probing</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[probing]" required>
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
											<select class="form-control cholamandlam_points" name="data[clarity_speech]" required>
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
											<select class="form-control cholamandlam_points" name="data[pace_speech]" required>
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
											<select class="form-control cholamandlam_points" name="data[interruption]" required>
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
											<select class="form-control cholamandlam_points" name="data[active_listening]" required>
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
											<select class="form-control cholamandlam_points" name="data[telephone_etiquette]" required>
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
											<select class="form-control cholamandlam_points" name="data[lack_energy]" required>
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
											<select class="form-control cholamandlam_points" name="data[empathy]" required>
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
											<select class="form-control cholamandlam_points" name="data[hold_procedure]" required>
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
											<select class="form-control cholamandlam_points" name="data[dead_air]" required>
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
											<select class="form-control cholamandlam_points" name="data[stammering]" required>
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
											<select class="form-control cholamandlam_points" name="data[digital_pitch]" required>
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
											<select class="form-control cholamandlam_points" name="data[sales_pitch]" required>
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
											<select class="form-control cholamandlam_points" name="data[closing_script]" required>
												<option cholamandlam_val=4 <?php echo $cholamandlam['closing_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=4 <?php echo $cholamandlam['closing_script'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam['closing_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>										

									<tr>
										<td>Correct Disposition</td>
										<td><input type="text" class="form-control" name="data[correct_disposition]" value="<?php echo $cholamandlam['correct_disposition'] ?>" required></td>
										<td>Disposition selected by agent</td>
										<td><input type="text" class="form-control" name="data[disposition_agent]" value="<?php echo $cholamandlam['disposition_agent'] ?>" required></td>
										<td>Wrong Disposition -Failure Remarks</td>
										<td><input type="text" class="form-control" name="data[failure_remarks]" value="<?php echo $cholamandlam['failure_remarks'] ?>" required></td>
									</tr>
									<tr>
										<td>Maintain Professionalism - Failure Reason</td>
										<td><input type="text" class="form-control" name="data[failure_reason]" value="<?php echo $cholamandlam['failure_reason'] ?>" required></td>
										<td>Standard call opening Adherence</td>
										<td><input type="text" class="form-control" name="data[standard_call]" value="<?php echo $cholamandlam['standard_call'] ?>" required></td>
										<td>Pick up call validation</td>
										<td><input type="text" class="form-control" name="data[call_validation]" value="<?php echo $cholamandlam['call_validation'] ?>" required></td>
									<tr>
										<td>EMI Amount Confirmation</td>
										<td><input type="text" class="form-control" name="data[emi_amount]" value="<?php echo $cholamandlam['emi_amount'] ?>" required></td>
										<td>Address Confirmation</td>
										<td><input type="text" class="form-control" name="data[address]" value="<?php echo $cholamandlam['address'] ?>" required></td>
										<td>Invalid Pickup Remarks (If any)</td>
										<td><input type="text" class="form-control" name="data[pickup_remarks]" value="<?php echo $cholamandlam['pickup_remarks'] ?>" required></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $cholamandlam['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $cholamandlam['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($cholamandlam_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($cholamandlam['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$cholamandlam['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($cholamandlam_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $cholamandlam['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $cholamandlam['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $cholamandlam['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $cholamandlam['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($cholamandlam_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($cholamandlam['entry_date'],72) == true){ ?>
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
