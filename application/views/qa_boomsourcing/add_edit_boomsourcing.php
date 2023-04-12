<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:30px;
	font-weight:bold;
	background-color:#3b5998;
	color:white;
}

.eml{
	font-weight:bold;
	font-size:18px;
	background-color:#85C1E9;
}

</style>


<?php if($boomsourcing['agnt_fd_acpt']!='Not Accepted' && $boomsourcing['audit_type']=='CQ Audit'){ 
if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){ ?>
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
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader">Boomsourcing AUDIT SHEET</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($ss_id==0){
											$auditorName = get_username();
											$auditDate = GetLocalMDYDate();
											$auditorCenter = $auditorLocation;
											$clDate_val='';
										}else{
											if($boomsourcing['entry_by']!=''){
												$auditorName = $boomsourcing['auditor_name'];
											}else{
												$auditorName = $boomsourcing['client_name'];
											}
											$auditorCenter = $boomsourcing['auditor_center'];
											//$auditDate = mysql2mmddyy($boomsourcing['audit_date']);
											$auditDate = ConvServerToLocal($boomsourcing['entry_date']);
											$clDate_val = mysqlDt2mmddyy($boomsourcing['call_date']);
										}
									?>
									
									<tr>
										<td>Name of Auditor:</td>
										<td style="width:230px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Date of Audit:</td>
										<td style="width:230px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Ticket/Transaction ID:<span style="color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $boomsourcing['ticket_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Agent/Rep's Name:<span style="color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
												<?php
													$date1 = str_replace('-"', '', $boomsourcing['doj']);
													$newDate1 = date("mY", strtotime($date1)); 
												?>
												<option value="<?php echo $boomsourcing['agent_id']; ?>"><?php echo $boomsourcing['fname']."".$boomsourcing['office_id']."".$newDate1; ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  
													$date2 = str_replace('-"', '', $row['doj']);
													$newDate2 = date("mY", strtotime($date2)); 
												?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['fname']."".$row['office_id']."".$newDate2; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>USER ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" value="<?php echo $boomsourcing['fusion_id'] ?>"></td>
										<td>L1 Supervisor:<span style="color:red">*</span></td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" required>
												<option value="<?php echo $boomsourcing['tl_id'] ?>"><?php echo $boomsourcing['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
											<!--<input type="text" readonly class="form-control" id="tl_name" value="<?php echo $boomsourcing['tl_name'] ?>">-->
											<!--<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $boomsourcing['tl_id'] ?>">-->
										</td>
									</tr>
									<tr>
										<td>Call/Transaction Date:<span style="color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
										<!-- <td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $boomsourcing['call_duration'] ?>" required ></td> -->
										<td>Zone/Center:</td>
										<td><input type="text" class="form-control" id="office_name" name="data[zone]" value="<?php echo $boomsourcing['zone'] ?>" readonly></td>
										<td>Link:<span style="color:red">*</span></td>
										<td><input type="text" class="form-control" id="link" name="data[link]" value="<?php echo $boomsourcing['link'] ?>" required ></td>
									</tr>
									<tr>
										<td>Phone:<span style="color:red">*</span></td>
										<td><input type="text" class="form-control" id="phone" name="data[phone]" onkeyup="checkDec(this);" value="<?php echo $boomsourcing['phone'] ?>" required></td>
										<td>Week No:</td>
										<td>
										<?php
											if($ss_id==0){
												$curr_week=date("W");
											}else{
												$curr_week=$boomsourcing['week'];
											}
										?>
											<input type="number" class="form-control"  name="data[week]" value="<?php echo $curr_week ?>" readonly>
										</td>
										<td>Disposition:<span style="color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[disposition]" value="<?php echo $boomsourcing['disposition'] ?>" required></td>
									</tr>
									<tr>
										<!-- <td>Campaign:</td>
										<td><input type="text" class="form-control" name="data[campaign]" value="<?php //echo $boomsourcing['campaign'] ?>" required></td> -->
										<td>Q Score:</td>
										<td>
											<select class="form-control" name="data[q_score]" required>
												<option value="">-Select-</option>
												<option <?php echo $boomsourcing['q_score']=='Q3'?"selected":""; ?> value="Q3">Q3</option>
												<option <?php echo $boomsourcing['q_score']=='Q2'?"selected":""; ?> value="Q2">Q2</option>
												<option <?php echo $boomsourcing['q_score']=='Q1'?"selected":""; ?> value="Q1">Q1</option>
												<option <?php echo $boomsourcing['q_score']=='Q0'?"selected":""; ?> value="Q0">Q0</option>
												<option <?php echo $boomsourcing['q_score']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<!--<td><input type="text" class="form-control" id="ncs" readonly name="data[ncs]" value="<?php echo $boomsourcing['ncs'] ?>"></td>-->
										<td>Vertical:<span style="color:red">*</span></td>
										<td>
											<select class="form-control" id="vertical" name="data[vertical]" required>
												<option value="" selected disabled>Select Vertical</option>
												<?php foreach($vertical_list as $vertical):?>
														<option value="<?php echo $vertical['id']?>" <?php echo $vertical['id'] == $boomsourcing['vertical'] ? 'selected' : '' ?>><?php echo $vertical['vertical']?></option>
												<?php endforeach;?>
											</select>
										</td>

										<td>Campaign:<span style="color:red">*</span></td>
										<td>
											<select class="form-control" id="campaign_process" name="data[campaign_process]" required>
												<option value="" selected disabled>Select Campaign</option>
												<?php foreach($campaign_list as $campaign):?>
														<option value="<?php echo $campaign['id']?>" <?php echo $campaign['id'] == $boomsourcing['campaign_process'] ? 'selected' : '' ?>><?php echo $campaign['campaign']?></option>
												<?php endforeach;?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:<span style="color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
												<?php if(get_dept_folder()=='training'){ ?>
													<option <?php echo $boomsourcing['audit_type']=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
													<option <?php echo $boomsourcing['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<?php }else if(get_dept_folder()=='operations'){ ?>
													<option <?php echo $boomsourcing['audit_type']=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
												<?php }else{ ?>
													<option <?php echo $boomsourcing['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
													<option <?php echo $boomsourcing['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
													<option <?php echo $boomsourcing['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
													<option <?php echo $boomsourcing['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
													<option <?php echo $boomsourcing['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
													<option <?php echo $boomsourcing['audit_type']=='Recertification Audit'?"selected":""; ?> value="Recertification Audit">Recertificate Audit</option>
													<option <?php echo $boomsourcing['audit_type']=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
													<option <?php echo $boomsourcing['audit_type']=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
													<option <?php echo $boomsourcing['audit_type']=='OJT'?"selected":""; ?> value="OJT">OJT</option>
												<?php } ?>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:<span style="color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
												<option <?php echo $boomsourcing['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $boomsourcing['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $boomsourcing['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $boomsourcing['voc']=='0'?"selected":""; ?> value="0">0</option>
											</select>
										</td>
									</tr>
									
									<tr style="font-weight:bold">
										<td style="font-size:18px; text-align:right">Earn Score:</td>
										<td><input type="text" class="form-control" id="earnScore" name="data[earned_score]"value="<?php echo $boomsourcing['earned_score'] ?>" readonly></td>
										<td style="font-size:18px; text-align:right">Possible Score:</td>
										<td><input type="text" class="form-control" id="possibleScore" name="data[possible_score]"value="<?php echo $boomsourcing['possible_score'] ?>" readonly></td>
										<td style="font-size:18px; text-align:right">Total Score:</td>
										<td><input type="text" class="form-control boomsourcingFatal" id="overallScore" name="overall_score" value="<?php echo $boomsourcing['overall_score'] ?>" readonly></td>
									</tr>
									<tr>
										<td><input type="hidden" class="form-control" id="boomsourcing_prefatal" name="data[pre_fatal_score]" value="<?php echo $boomsourcing['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="boomsourcing_fatalcount" name="data[fatal_count]" value="<?php echo $boomsourcing['fatal_count'] ?>"></td>
									</tr>
									<tr style=" font-weight:bold;background-color:#6d71e3 ;color: white;">
										<td colspan=3>Quality Attribute</td>
										<td>Weightage</td>
										<td>Status</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td colspan=3>Minor Interruption/s/Talking over</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[talking_over]" required>
												<option boomsourcing_val=5 <?php echo $boomsourcing['talking_over'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['talking_over'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['talking_over'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm1]" value="<?php echo $boomsourcing['comm1'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Unnecessary key pressed of nodes</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[key_pressed]" required>
												<option boomsourcing_val=10 <?php echo $boomsourcing['key_pressed'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['key_pressed'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['key_pressed'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm2]" value="<?php echo $boomsourcing['comm2'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Start/stopping of nodes</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[start_stop_nodes]" required>
												<option boomsourcing_val=10 <?php echo $boomsourcing['start_stop_nodes'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['start_stop_nodes'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['start_stop_nodes'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm3]" value="<?php echo $boomsourcing['comm3'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Lags/Delayed responses (3-5 seconds)</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[delayed_responses]" required>
												<option boomsourcing_val=5 <?php echo $boomsourcing['delayed_responses'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['delayed_responses'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['delayed_responses'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm4]" value="<?php echo $boomsourcing['comm4'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Dead air (6 seconds to 10)</td>
										<td>15</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[dead_air]" required>
												<option boomsourcing_val=15 <?php echo $boomsourcing['dead_air'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=15 <?php echo $boomsourcing['dead_air'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=15 <?php echo $boomsourcing['dead_air'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm5]" value="<?php echo $boomsourcing['comm5'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Active Listening/asked to repeat clearly answered question</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[active_listening]" required>
												<option boomsourcing_val=5 <?php echo $boomsourcing['active_listening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['active_listening'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['active_listening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm6]" value="<?php echo $boomsourcing['comm6'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Incorrect responses/Incorrect rebuttal used</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[incorrect_responses]" required>
												<option boomsourcing_val=10 <?php echo $boomsourcing['incorrect_responses'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['incorrect_responses'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['incorrect_responses'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm7]" value="<?php echo $boomsourcing['comm7'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Hand off Issue/s</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[hand_off_issue]" required>
												<option boomsourcing_val=10 <?php echo $boomsourcing['hand_off_issue'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['hand_off_issue'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['hand_off_issue'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm8]" value="<?php echo $boomsourcing['comm8'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Failed to get for affirmative answer before transferring</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[affirmative_answer]" required>
												<option boomsourcing_val=10 <?php echo $boomsourcing['affirmative_answer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['affirmative_answer'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['affirmative_answer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm9]" value="<?php echo $boomsourcing['comm9'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Wrong Disposition (not 100% rep error)</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[wrong_disposition]" required>
												<option boomsourcing_val=5 <?php echo $boomsourcing['wrong_disposition'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['wrong_disposition'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['wrong_disposition'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm10]" value="<?php echo $boomsourcing['comm10'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Incomplete information (optional)</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[incomplete_information]" required>
												<option boomsourcing_val=5 <?php echo $boomsourcing['incomplete_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['incomplete_information'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing['incomplete_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm11]" value="<?php echo $boomsourcing['comm11'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3>Scrambling of script</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[scrambling_script]" required>
												<option boomsourcing_val=10 <?php echo $boomsourcing['scrambling_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['scrambling_script'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing['scrambling_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm12]" value="<?php echo $boomsourcing['comm12'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Major interruption/talking over</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF1" name="data[major_interruption]" required>
												<option boomsourcing_val=0 <?php echo $boomsourcing['major_interruption'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['major_interruption'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['major_interruption'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm13]" value="<?php echo $boomsourcing['comm13'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Skipping /cutting of script</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF2" name="data[cutting_script]" required>
												<option boomsourcing_val=0 <?php echo $boomsourcing['cutting_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['cutting_script'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['cutting_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm14]" value="<?php echo $boomsourcing['comm14'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Failed to rebut</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF3" name="data[failed_rebut]" required>
												<option boomsourcing_val=0 <?php echo $boomsourcing['failed_rebut'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['failed_rebut'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['failed_rebut'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm15]" value="<?php echo $boomsourcing['comm15'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Over pushing</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF4" name="data[over_pushing]" required>
												<option boomsourcing_val=0 <?php echo $boomsourcing['over_pushing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['over_pushing'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['over_pushing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm16]" value="<?php echo $boomsourcing['comm16'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Legal Compliance/Sales Falsification</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF5" name="data[legal_compliance]" required>
												<option boomsourcing_val=0 <?php echo $boomsourcing['legal_compliance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['legal_compliance'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['legal_compliance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm17]" value="<?php echo $boomsourcing['comm17'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Call avoidance (Over staying >10sec)</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF6" name="data[call_avoidance]" required>
												<option boomsourcing_val=0 <?php echo $boomsourcing['call_avoidance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['call_avoidance'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['call_avoidance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm18]" value="<?php echo $boomsourcing['comm18'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Failed to provide all the necessary info (required)</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF7" name="data[necessary_info]" required>
												<option boomsourcing_val=0 <?php echo $boomsourcing['necessary_info'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['necessary_info'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['necessary_info'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm19]" value="<?php echo $boomsourcing['comm19'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Failed to bowout</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF8" name="data[failed_bowout]" required>
												<option boomsourcing_val=0 <?php echo $boomsourcing['failed_bowout'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['failed_bowout'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['failed_bowout'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm20]" value="<?php echo $boomsourcing['comm20'] ?>"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Wrong Disposition (rep error)</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF9" name="data[wrong_disposition_error]" required>
												<option boomsourcing_val=0 <?php echo $boomsourcing['wrong_disposition_error'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['wrong_disposition_error'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing['wrong_disposition_error'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm21]" value="<?php echo $boomsourcing['comm21'] ?>"></td>
									</tr>
									
									<!--<tr>
										<td>Very Interested/No objection (Q3):</td>
										<td colspan=2><textarea class="form-control" name="data[no_objection]"><?php echo $boomsourcing['no_objection'] ?></textarea></td>
										<td>Asked a question but no objection/Hung Up within 10 seconds of transferring (Q2):</td>
										<td colspan=2><textarea class="form-control" name="data[hung_up]"><?php echo $boomsourcing['hung_up'] ?></textarea></td>
									</tr>
									<tr>
										<td>Declined once but agreed after rep rebut (Q1):</td>
										<td colspan=2><textarea class="form-control" name="data[rep_rebut]"><?php echo $boomsourcing['rep_rebut'] ?></textarea></td>
										<td>Failed to meet the qualifications. INVALID (Q0):</td>
										<td colspan=2><textarea class="form-control" name="data[meet_qualifications]"><?php echo $boomsourcing['meet_qualifications'] ?></textarea></td>
									</tr>-->
									<tr>
										<td>Incorrectly Disposed/None qualified tagged as Transfers:</td>
										<td colspan=3><textarea class="form-control" name="data[incorrectly_disposed]"><?php echo $boomsourcing['incorrectly_disposed'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $boomsourcing['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $boomsourcing['feedback'] ?></textarea></td>
									</tr>
									<tr style="background-color:#F5B7B1">
										<td colspan=2>Upload Audio Files (WAV,WMV,MP3,MP4)</td>
										<?php if($ss_id==0){ ?>
											<td colspan=2><input type="file" multiple class="form-control audioFile" id="attach_file" name="attach_file[]"></td>
											<td colspan=2>
												<?php echo '<a class="btn btn-warning" style="font-size:15px" href="'.base_url().'Qa_boomsourcing/record_audio/'.$ss_id.'" target="a_blank" style="margin-left:5px; font-size:10px;">Record Audio Here</a>';  ?>
											</td>
										<?php }else{ ?>
											<td colspan=2><input type="file" multiple class="form-control audioFile" id="attach_file" name="attach_file[]"></td>
										<?php if($boomsourcing['attach_file']!=''){ ?>
											<td colspan=2>
												<?php $attach_file = explode(",",$boomsourcing['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/Qa_boomsourcing/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/Qa_boomsourcing/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan="2"><b>No Audio Files Uploaded</b></td>';
											  }
										} ?>
									</tr>
									<tr style="background-color:#A5DDBD">
										<td colspan="2">Upload Screenshot Files (JPG,JPEG,PNG)</td>
										<?php if($ss_id==0){ ?>
											<td colspan=2><input type="file" multiple class="form-control imageFile" name="attach_img_file[]"></td>
										<?php }else{ 
											if($boomsourcing['attach_img_file']!=''){ ?>
											<td colspan="4">
												<?php $attach_img_file = explode(",",$boomsourcing['attach_img_file']);
												 foreach($attach_img_file as $mp){ ?>
													<button class="btn btn-info"><a href="<?php echo base_url(); ?>qa_files/Qa_boomsourcing/<?php echo $mp; ?>"><?php echo $mp; ?></a></button>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan="4"><b>No Screenshot Files Uploaded</b></td>';
											  }
										} ?>
									</tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<?php if($ss_id!=0){ ?>
									
										<tr>
											<?php
												if($boomsourcing['agnt_fd_acpt']=='Not Accepted') $agntStyle='style="color:red"';
												else $agntStyle='style="color:green"';
											?>
											<td style="font-size:16px; font-weight:bold">Agent Review:</td><td <?php echo $agntStyle ?>><?php echo $boomsourcing['agnt_fd_acpt'] ?></td>
											<td style="font-size:16px; font-weight:bold">Review Comment:</td><td colspan=3><?php echo $boomsourcing['agent_rvw_note'] ?></td>
										</tr>
									<!------------------------>	
										<?php if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){ ?>
											<tr style="background-color:#D7BDE2">
												<td style="font-size:16px; font-weight:bold">QA Rebuttal:</td><td><?php echo $boomsourcing['qa_rebuttal'] ?></td>
												<td style="font-size:16px; font-weight:bold">Rebuttal By:</td><td><?php echo $boomsourcing['qa_rebuttal_name'] ?></td>
												<td style="font-size:16px; font-weight:bold">Rebuttal Comment:</td><td colspan=2><?php echo $boomsourcing['qa_rebuttal_comment'] ?></td>
											</tr>
											<tr style="background-color:#D7BDE2">
												<td style="font-size:16px; font-weight:bold">QA TL/Manager Rebuttal:</td><td><?php echo $boomsourcing['qa_mgnt_rebuttal'] ?></td>
												<td style="font-size:16px; font-weight:bold">TL/Manager Rebuttal By:</td><td><?php echo $boomsourcing['qa_mgnt_rebuttal_name'] ?></td>
												<td style="font-size:16px; font-weight:bold">TL/Manager Rebuttal Comment:</td><td colspan=2><?php echo $boomsourcing['qa_mgnt_rebuttal_comment'] ?></td>
											</tr>
										<?php }else if(get_role_dir()=='agent' && get_dept_folder()=='qa'){ ?>
											<tr style="background-color:#D7BDE2">
												<td style="font-size:16px; font-weight:bold">QA Rebuttal:</td><td><?php echo $boomsourcing['qa_rebuttal'] ?></td>
												<td style="font-size:16px; font-weight:bold">Rebuttal By:</td><td><?php echo $boomsourcing['qa_rebuttal_name'] ?></td>
												<td style="font-size:16px; font-weight:bold">Rebuttal Comment:</td><td colspan=2><?php echo $boomsourcing['qa_rebuttal_comment'] ?></td>
										<?php }else{ ?>
											<tr><td style="font-size:16px; font-weight:bold">Operation TL/Manager Review:</td><td colspan=4><?php echo $boomsourcing['mgnt_rvw_note'] ?></td></tr>
											<tr><td colspan=2  style="font-size:16px">TL/Manager Review</td><td colspan=4><textarea class="form-control1" style="width:300px; height:40px" id="note" name="note" required></textarea></td></tr>
										<?php } ?>
										
										<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
										
										<!-------------------- QA REBUTTAL ---------------------->
										<?php 
										if($boomsourcing['audit_type']=='CQ Audit' && $boomsourcing['agnt_fd_acpt']=='Not Accepted'){
											
											/* if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){ 
												$rebuttal_name='qa_rebuttal';
												$rebuttal_comm_name='qa_rebuttal_comment';
											}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
												$rebuttal_name='qa_mgnt_rebuttal';
												$rebuttal_comm_name='qa_mgnt_rebuttal_comment';
											} */
										?>
										<?php if(get_role_dir()=='agent' && get_dept_folder()=='qa'){ ?>
											<tr style="background-color:#D4E6F1">
												<td>QA's Rebuttal</td>
												<td>
													<select class="form-control1" style="background-color:#D4E6F1; width:200px; height:40px" name="qa_rebuttal" required>
														<option value="">-Select-</option>
														<option value="Accepted">Accepted</option>
														<option value="Not Accepted">Not Accepted</option>
													</select>
												</td>
												<td>Rebuttal Comment</td>
												<td colspan=3><textarea class="form-control1" style="background-color:#D4E6F1; width:500px; height:80px" name="qa_rebuttal_comment" required></textarea></td>
											</tr>
										<?php }else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){ ?>
											<tr style="background-color:#D4E6F1">
												<td>QA's <?php echo get_role_dir() ?> Rebuttal</td>
												<td>
													<select class="form-control1" style="background-color:#D4E6F1; width:200px; height:40px" name="qa_mgnt_rebuttal" required>
														<option value="">-Select-</option>
														<option value="Accepted">Accepted</option>
														<option value="Not Accepted">Not Accepted</option>
													</select>
												</td>
												<td>Rebuttal Comment</td>
												<td colspan=3><textarea class="form-control1" style="background-color:#D4E6F1; width:500px; height:80px" name="qa_mgnt_rebuttal_comment" required></textarea></td>
											</tr>
										<?php } ?>
										<!------------------------------------------------------->
										
									<?php }
									} 
									?>
									
									<?php 
									if($ss_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){
											if($boomsourcing['agnt_fd_acpt']=='Not Accepted' && $boomsourcing['audit_type']=='CQ Audit'){
												if((get_role_dir()=='agent' && get_dept_folder()=='qa') && $boomsourcing['qa_rebuttal']==''){
													echo '<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" name="btnSave" value="SAVE" style="width:500px">SUBMIT QA REBUTTAL</button></td></tr>';
												}else if(((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa') && $boomsourcing['qa_mgnt_rebuttal']==''){
													echo '<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" name="btnSave" value="SAVE" style="width:500px">SUBMIT REBUTTAL</button></td></tr>';
												}
											}else if($boomsourcing['audit_type']!='CQ Audit'){
												echo '<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" name="btnSave" value="SAVE" style="width:500px">SAVE</button></td></tr>';
											}else{
												echo '<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" name="btnSave" value="SAVE" style="width:500px">SAVE</button></td></tr>';
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
