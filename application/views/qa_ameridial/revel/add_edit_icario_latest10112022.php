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
				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
					
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr>
										<td colspan="6" id="theader" style="font-size:30px">Icario Latest Score card</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($icario_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($icario['entry_by']!=''){
												$auditorName = $icario['auditor_name'];
											}else{
												$auditorName = $icario['client_name'];
											}
											$auditDate = mysql2mmddyy($icario['audit_date']);
											$clDate_val = mysql2mmddyy($icario['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td style="width:200px"><input type="text" class="form-control" onkeydown="return false;"  id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<?php if($icario['agent_id']){ ?>
												<option value="<?php echo $icario['agent_id'] ?>"><?php echo $icario['fname']." ".$icario['lname'] ?></option>
											   <?php } ?>
												<option value="">--Select--</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $icario['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" name="data[tl_id]" id="tl_id"  readonly>
												<option value="<?php echo $icario['tl_id'] ?>"><?php echo $icario['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $icario['call_duration'] ?>" required></td>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $icario['audit_type'] ?>"><?php echo $icario['audit_type'] ?></option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<!-- <option value="Calibration">Calibration</option> -->
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
											</select>
										</td>
										<!-- <td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td> -->
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $icario['voc'] ?>"><?php echo $icario['voc'] ?></option>
												
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
										<td>File No:</td>
										<td><input type="text" class="form-control" name="data[file_no]" value="<?php echo $icario['file_no'] ?>" required></td>

										<td>Process Name:</td>
										<td colspan="4">
											<select class="form-control" id="process_name" name="data[process_name]" required>
												<option value="<?php echo $icario['process_name'] ?>"><?php echo $icario['process_name'] ?></option>
												
												<option value="RVLA-Revel Health Outbound">RVLA-Revel Health Outbound</option>
												<option value="RVLB-Highmark">RVLB-Highmark</option>
												<option value="RVLB-Revel Authenticate">RVLB-Revel Authenticate</option>
												<option value="REVI-Revel Health">REVI-Revel Health</option>
												
											</select>
										</td>
									</tr>
									
									<tr>
										<td style="font-size:16px; font-weight:bold" colspan="1">MECHANICS Earned Score</td>
										<td><input type="text" readonly class="form-control" id="fb_earnedScore2" name ="data[mechanics_earned_score]" value="<?php //echo $icario['earned_score'] ?>"></td><td style="font-size:16px; font-weight:bold" colspan="1">MECHANICS Possible Score</td>
										<td><input type="text" readonly class="form-control" id="fb_possibleScore2" name ="data[mechanics_possible_score]" value="<?php //echo $icario['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">MECHANICS Overall Score:</td>
										<td><input type="text" readonly id="icario_overallScore2" name="data[mechanics_overall_score]" class="form-control" style="font-weight:bold" value="<?php //echo $icario['mechanics_overall_score'] ?>"></td>
									</tr>
									<tr>
										<td style="font-size:16px; font-weight:bold" colspan="1">SOFT SKILLS Earned Score</td>
										<td><input type="text" readonly class="form-control" id="fb_earnedScore3" name ="data[soft_skills_earned_score]" value="<?php //echo $icario['earned_score22'] ?>"></td><td style="font-size:16px; font-weight:bold" colspan="1">SOFT SKILLS Possible Score</td>
										<td><input type="text" readonly class="form-control" id="fb_possibleScore3" name ="data[soft_skills_possible_score]" value="<?php //echo $icario['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">SOFT SKILLS Overall Score:</td>
										<td><input type="text" readonly id="icario_overallScore3" name="data[soft_skills_overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $icario['soft_skills_overall_score'] ?>"></td>
									</tr>

									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan=""><input type="text" readonly class="form-control" id="cust_score_percent" name="data[cust_score]" value="<?php echo $icario['cust_score'] ?>"></td><td style="font-size:18px; font-weight:bold" colspan="">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan=""><input type="text" readonly class="form-control" id="busi_score_percent" name="data[busi_score]" value="<?php echo $icario['busi_score'] ?>"></td>
										<td style="font-size:18px; font-weight:bold" colspan="">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan=""><input type="text" readonly class="form-control" id="comp_score_percent" name="data[comp_score]" value="<?php echo $icario['comp_score'] ?>"></td>
									</tr>


									<tr>
										<td style="font-size:16px; font-weight:bold" colspan="1">Earned Score</td>
										<td><input type="text" readonly class="form-control" id="fb_earnedScore1" name="data[earned_score]" value="<?php echo $icario['earned_score'] ?>"></td><td style="font-size:16px; font-weight:bold" colspan="1">Possible Score</td>
										<td><input type="text" readonly class="form-control" id="fb_possibleScore1" name="data[possible_score]" value="<?php echo $icario['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="icario_overallScore" name="data[overall_score]" class="form-control icaAutofail" style="font-weight:bold" value="<?php echo $icario['overall_score'] ?>"></td>
									</tr>
									
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td colspan=2>Item</td>
										
										<td>Coefficient</td>
										<td>Rating</td>
										<td>Proposition</td>
										<td colspan=1>Criticalities</td>
									</tr>

									<tr><td class="eml" colspan=6>MECHANICS</td></tr>
									<tr>
										<td style="text-align:left;" colspan=2>1.M.1 Agent greeted the member, used correct client opening, introduced themselves, and continued following the basic scripting to open the call</td>
										<td>
											<select class="form-control icario_point  mechanic busi" id="" name="data[mechanics1]" required>
												<option icario_val=6 <?php echo $icario['mechanics1'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=6 <?php echo $icario['mechanics1'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=6 <?php echo $icario['mechanics1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>6</td>
										<td ><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $icario['cmt1'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>1.M.2 Agent properly authenticated the member</td>
										<td>
											<select class="form-control icario_point mechanic comp" name="data[mechanics2]" required>
												<option icario_val=5 <?php echo $icario['mechanics2'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=5 <?php echo $icario['mechanics2'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=5 <?php echo $icario['mechanics2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td ><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $icario['cmt2'] ?>"></td>

										<td>Compliance Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>1.M.3 Agent collected Health Care information/Responses correctly</td>
										<td>
											<select class="form-control icario_point mechanic busi" name="data[mechanics3]" required>
												<option icario_val=5 <?php echo $icario['mechanics3'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=5 <?php echo $icario['mechanics3'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=5 <?php echo $icario['mechanics3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $icario['cmt3'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									
									<tr>
										<td style="text-align:left;" colspan=2>1.M.4 Agent gave correct and complete information</td>
										<td>
											<select class="form-control icario_point mechanic cust" name="data[mechanics4]" required>
												<option icario_val=5 <?php echo $icario['mechanics4'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=5 <?php echo $icario['mechanics4'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=5 <?php echo $icario['mechanics4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $icario['cmt4'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>1.M.5 Agent gave correct incentive information</td>
										<td>
											<select class="form-control icario_point mechanic busi" name="data[mechanics5]" required>
												<option icario_val=5 <?php echo $icario['mechanics5'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=5 <?php echo $icario['mechanics5'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=5 <?php echo $icario['mechanics5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $icario['cmt5'] ?>"></td>
										<td>Business Critical</td>
									</tr>
					
									<tr>
										<td style="text-align:left;" colspan=2>1.M.6 Agent provided online, self-service information</td>
										<td>
											<select class="form-control icario_point mechanic cust" name="data[mechanics6]" required>
												<option icario_val=3 <?php echo $icario['mechanics6'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=3 <?php echo $icario['mechanics6'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=3 <?php echo $icario['mechanics6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>3</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $icario['cmt6'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>1.M.7 Agent logged call correctly in all appropriate systems</td>
										<td>
											<select class="form-control icario_point mechanic busi" name="data[mechanics7]" required>
												<option icario_val=3 <?php echo $icario['mechanics7'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=3 <?php echo $icario['mechanics7'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=3 <?php echo $icario['mechanics7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>3</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $icario['cmt7'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>1.M.8 Agent followed script guidelines</td>
										<td>
											<select class="form-control icario_point mechanic busi" name="data[mechanics8]" required>
												<option icario_val=12 <?php echo $icario['mechanics8'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=12 <?php echo $icario['mechanics8'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=12 <?php echo $icario['mechanics8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>12</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $icario['cmt8'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>1.M.9 Agent resolved all questions and concerns</td>
										<td>
											<select class="form-control icario_point mechanic cust" name="data[mechanics9]" required>
												<option icario_val=6 <?php echo $icario['mechanics9'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=6 <?php echo $icario['mechanics9'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=6 <?php echo $icario['mechanics9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>6</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $icario['cmt9'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									
									<tr><td class="eml" colspan=6>SOFT SKILLS</td></tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.1 Agent displayed active listening skills, and probed for details effectively</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills1]" required>
												<option icario_val=4 <?php echo $icario['soft_skills1'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills1'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $icario['cmt10'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.2 Agent effectively engaged with the caller</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills2]" required>
												<option icario_val=4 <?php echo $icario['soft_skills2'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills2'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $icario['cmt11'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.3 Agent maintained appropriate pace with caller</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills3]" required>
												<option icario_val=4 <?php echo $icario['soft_skills3'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills3'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $icario['cmt12'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.4 Agent Displayed a polite and appropriate tone</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills4]" required>
												<option icario_val=4 <?php echo $icario['soft_skills4'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills4'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $icario['cmt13'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.5 Agent sounded confident and knowledgeable</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills5]" required>
												<option icario_val=4 <?php echo $icario['soft_skills5'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills5'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $icario['cmt14'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.6 Agent did not interrupt or talk over the member</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills6]" required>
												<option icario_val=4 <?php echo $icario['soft_skills6'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills6'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $icario['cmt15'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.7 Agent used pleasing words and phrases between member responses</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills7]" required>
												<option icario_val=4 <?php echo $icario['soft_skills7'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills7'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $icario['cmt16'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.8 Agent used pleasing words and phrases at beginning and end of call</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills8]" required>
												<option icario_val=4 <?php echo $icario['soft_skills8'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills8'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $icario['cmt17'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.9 Agent maintained call control</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills9]" required>
												<option icario_val=4 <?php echo $icario['soft_skills9'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills9'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $icario['cmt18'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.10 Agent managed silence/hold times</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills10]" required>
												<option icario_val=4 <?php echo $icario['soft_skills10'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills10'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $icario['cmt19'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" colspan=2>2.S.11 Agent used correct grammar avoided slang</td>
										<td>
											<select class="form-control icario_point soft_skill cust" name="data[soft_skills11]" required>
												<option icario_val=4 <?php echo $icario['soft_skills11'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=4 <?php echo $icario['soft_skills11'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=4 <?php echo $icario['soft_skills11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>4</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt20]" value="<?php echo $icario['cmt20'] ?>"></td>
										<td>Customer Critical</td>
									</tr>

									<tr>
										<td style="text-align:left;" colspan=2>2.S.12 Agent used correct client closing</td>
										<td>
											<select class="form-control icario_point soft_skill busi" name="data[soft_skills12]" required>
												<option icario_val=6 <?php echo $icario['soft_skills12'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=6 <?php echo $icario['soft_skills12'] == "No"?"selected":"";?> value="No">No</option>
												<option icario_val=6 <?php echo $icario['soft_skills12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>6</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt21]" value="<?php echo $icario['cmt21'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									

									<tr><td class="eml" colspan=6>AUTO-FAIL</td></tr>
									<tr>
										<td style="text-align:left; color:red" colspan=2>3.A.1 Agent submitted escalation in system when required (Auto-Fail)</td>
										<td>
											<select class="form-control icario_point soft_skill busi" id="icaF1" name="data[auto_fail1]" required>
												<option icario_val=0 <?php echo $icario['auto_fail1']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=0 <?php echo $icario['auto_fail1']=="No"?"selected":"";?> value="No">No</option>
												
											</select>
										</td>
										<td>0</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt22]" value="<?php echo $icario['cmt22'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left; color: red;" colspan=2>3.A.2 Agent was not rude or inappropriate? (Auto-Fail)</td>
										<td>
											<select class="form-control icario_point soft_skill comp" id="icaF2" name="data[auto_fail2]" required>
												<option icario_val=0 <?php echo $icario['auto_fail2']=="Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=0 <?php echo $icario['auto_fail2']=="No"?"selected":"";?> value="No">No</option>
												
												
											</select>
										</td>
										<td>0</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt23]" value="<?php echo $icario['cmt23'] ?>"></td>
										<td>Compliance Critical</td>
									</tr>
									<tr>
										<td style="text-align:left; color: red;" colspan=2>3.A.3 Agent used incorrect client name during the call (Auto-Fail)</td>
										<td>
											<select class="form-control icario_point soft_skill busi" id="icaF3" name="data[auto_fail3]" required>
												<option icario_val=0 <?php echo $icario['auto_fail3'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=0 <?php echo $icario['auto_fail3'] == "No"?"selected":"";?> value="No">No</option>
												
												
											</select>
										</td>
										<td>0</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt24]" value="<?php echo $icario['cmt24'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left; color:red" colspan=2>3.A.4 Agent did not demonstrate call avoidance (Auto-Fail)</td>
										<td>
											<select class="form-control icario_point soft_skill comp" id="icaF4" name="data[auto_fail4]" required>
												<option icario_val=0 <?php echo $icario['auto_fail4'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=0 <?php echo $icario['auto_fail4'] == "No"?"selected":"";?> value="No">No</option>
												
												
											</select>
										</td>
										<td>0</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt25]" value="<?php echo $icario['cmt25'] ?>"></td>
										<td>Compliance Critical</td>
									</tr>

									<tr>
										<td style="text-align:left; color:red" colspan=2>3.A.5 Agent properly authenticated the member  (Auto-Fail)</td>
										<td>
											<select class="form-control icario_point soft_skill comp" id="icaF5" name="data[auto_fail5]" required>
												<option icario_val=0 <?php echo $icario['auto_fail5'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option icario_val=0 <?php echo $icario['auto_fail5'] == "No"?"selected":"";?> value="No">No</option>
												
												
											</select>
										</td>
										<td>0</td>
										<td colspan=><input type="text" class="form-control" name="data[cmt26]" value="<?php echo $icario['cmt26'] ?>"></td>
										<td>Compliance Critical</td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control"   name="data[call_summary]"><?php echo $icario['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control"   name="data[feedback]"><?php echo $icario['feedback'] ?></textarea></td>
									</tr>

									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($icario_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($icario['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$icario['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_icario/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_icario/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($icario_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $icario['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $icario['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $icario['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $icario['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($icario_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									} else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($icario['entry_date'],72) == true){ ?>
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
