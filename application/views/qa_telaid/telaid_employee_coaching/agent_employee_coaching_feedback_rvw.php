<style>
	.table>tbody>tr>td {
		text-align: center;
		font-size: 13px;
	}

	#theader {
		font-size: 20px;
		font-weight: bold;
		background-color: #95A5A6;
	}

	.eml {
		background-color: #85C1E9;
	}
	.eml1{
		font-size:20px;
		font-weight:bold;
		background-color:#CCD1D1;
	}
	.fatal .eml{
		background-color: red;
		color:white;
	}

	.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}
</style>
<?php // .ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 //float: left;
	// display: none;
	//used for call_duration to disable now button.
	//} ?>



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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">Telaid Employee Agent Coaching Form</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										
											if ($telaid_employee_data['entry_by'] != '') {
												$auditorName = $telaid_employee_data['auditor_name'];
											} else {
												$auditorName = $telaid_employee_data['client_name'];
											}
										
											$auditDate = mysql2mmddyy($telaid_employee_data['audit_date']);
										 
											//$clDate_val = mysql2mmddyy($telaid_employee_data['call_date']);
										
											$agent_id = $telaid_employee_data['agent_id'];
											$fusion_id = $telaid_employee_data['fusion_id'];
											$agent_name = $telaid_employee_data['fname'] . " " . $telaid_employee_data['lname'] ;
											$tl_id = $telaid_employee_data['tl_id'];
											$tl_name = $telaid_employee_data['tl_name'];
											//$call_duration = $telaid_employee_data['call_duration'];
										
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Account:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="" name="account"  readonly value="Telaid" class="form-control" disabled>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
											<option value="">-Select-</option>
											<?php foreach($agentName as $row){
												$sCss='';
												if($row['id']==$agent_id) $sCss='selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php } ?>
										</select>
											</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" disabled value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
											</td>
										</tr>
										<tr>
											<td>LOB:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[lob]" disabled>
											    <option value="">-Select-</option>
											    <option value="HD 1.1" <?= ($telaid_employee_data['lob']=="HD 1.1")?"selected":"" ?>>HD 1.1</option>
												<option value="HD 1.2" <?= ($telaid_employee_data['lob']=="HD 1.2")?"selected":"" ?>>HD 1.2</option>
												<option value="HD 1.3" <?= ($telaid_employee_data['lob']=="HD 1.3")?"selected":"" ?>>HD 1.3</option>
												<option value="PM 1.1" <?= ($telaid_employee_data['lob']=="PM 1.1")?"selected":"" ?>>PM 1.1</option>
												<option value="PM 1.2" <?= ($telaid_employee_data['lob']=="PM 1.2")?"selected":"" ?>>PM 1.2</option>
												<option value="AP 1.1" <?= ($telaid_employee_data['lob']=="AP 1.1")?"selected":"" ?>>AP 1.1</option>
												<option value="SD 1.2" <?= ($telaid_employee_data['lob']=="SD 1.2")?"selected":"" ?>>SD 1.2</option>
										</select>
											</td>
											<td>Form No:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[form_no]" value="T001" readonly>
											</td>

											<td>Coach:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id='coach' name="data[coach]" value="<?php echo $telaid_employee_data['coach'] ?>" disabled>
											</td>
										</tr>
										
										<tr class="eml" style="height:25px; font-weight:bold">
											<td colspan='8' style="text-align:center; background-color:black; color: white;">FOCUS AREA</td>
										</tr>
										<tr>
											<td colspan='5' style="text-align:center;">Nature of Incident / Problem</td>
											<td style="text-align:center;">Status</td>
											<td colspan='2' style="text-align:center;">Remarks</td>
										</tr>
										<tr>
											<td rowspan='7'>(Select the Appropriate Options)</td>
											<td colspan='4'>Poor Job Performance</td>
											<td>
												<?php
												if($telaid_employee_data['poor_job_performance']=='Severe'){
													?>
													<select class="form-control"  id="poor_job_performance" name="data[poor_job_performance]" disabled style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="poor_job_performance" name="data[poor_job_performance]" disabled>
													<?php
												}
												?>
												
													<option <?php echo $telaid_employee_data['poor_job_performance']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $telaid_employee_data['poor_job_performance']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $telaid_employee_data['poor_job_performance']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $telaid_employee_data['poor_job_performance']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $telaid_employee_data['poor_job_performance']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" disabled name="data[cmt1]"><?php echo $telaid_employee_data['cmt1'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Violation of Procedural Guidelines</td>
											<td>
												<?php
												if($telaid_employee_data['procedural_guidelines']=='Severe'){
													?>
													<select class="form-control"  id="procedural_guidelines" name="data[procedural_guidelines]" disabled style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="procedural_guidelines" name="data[procedural_guidelines]" disabled>
													<?php
												}
												?>	
													<option <?php echo $telaid_employee_data['procedural_guidelines']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $telaid_employee_data['procedural_guidelines']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $telaid_employee_data['procedural_guidelines']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $telaid_employee_data['procedural_guidelines']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $telaid_employee_data['procedural_guidelines']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" disabled name="data[cmt2]"><?php echo $telaid_employee_data['cmt2'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Behavioral</td>
											<td>
												<?php
												if($telaid_employee_data['behavioral']=='Severe'){
													?>
													<select class="form-control"  id="behavioral" name="data[behavioral]" disabled style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="behavioral" name="data[behavioral]" disabled>
													<?php
												}
												?>	
													<option <?php echo $telaid_employee_data['behavioral']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $telaid_employee_data['behavioral']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $telaid_employee_data['behavioral']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $telaid_employee_data['behavioral']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $telaid_employee_data['behavioral']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" disabled name="data[cmt3]"><?php echo $telaid_employee_data['cmt3'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Attendance Infraction</td>
											<td>
												<?php
												if($telaid_employee_data['attendance_infraction']=='Severe'){
													?>
													<select class="form-control"  id="attendance_infraction" name="data[attendance_infraction]" disabled style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="attendance_infraction" name="data[attendance_infraction]" disabled>
													<?php
												}
												?>	
													<option <?php echo $telaid_employee_data['attendance_infraction']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $telaid_employee_data['attendance_infraction']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $telaid_employee_data['attendance_infraction']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $telaid_employee_data['attendance_infraction']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $telaid_employee_data['attendance_infraction']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" disabled name="data[cmt4]"><?php echo $telaid_employee_data['cmt4'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Changed Work Scenario</td>
											<td>
												<?php
												if($telaid_employee_data['work_scenario']=='Severe'){
													?>
													<select class="form-control"  id="work_scenario" name="data[work_scenario]" disabled style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="work_scenario" name="data[work_scenario]" disabled>
													<?php
												}
												?>	
													<option <?php echo $telaid_employee_data['work_scenario']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $telaid_employee_data['work_scenario']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $telaid_employee_data['work_scenario']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $telaid_employee_data['work_scenario']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $telaid_employee_data['work_scenario']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" disabled name="data[cmt5]"><?php echo $telaid_employee_data['cmt5'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Others (Please specify) Sleeping on Shift</td>
											<td>
												<?php
												if($telaid_employee_data['sleeping_shift']=='Severe'){
													?>
													<select class="form-control"  id="sleeping_shift" name="data[sleeping_shift]" disabled style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="sleeping_shift" name="data[sleeping_shift]" disabled>
													<?php
												}
												?>	
													<option <?php echo $telaid_employee_data['sleeping_shift']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $telaid_employee_data['sleeping_shift']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $telaid_employee_data['sleeping_shift']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $telaid_employee_data['sleeping_shift']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $telaid_employee_data['sleeping_shift']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" disabled name="data[cmt6]"><?php echo $telaid_employee_data['cmt6'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>None</td>
											<td>
												<?php
												if($telaid_employee_data['none']=='Severe'){
													?>
													<select class="form-control"  id="none" name="data[none]" disabled style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="none" name="data[none]" disabled>
													<?php
												}
												?>	
													<option <?php echo $telaid_employee_data['none']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $telaid_employee_data['none']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $telaid_employee_data['none']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $telaid_employee_data['none']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $telaid_employee_data['none']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" disabled name="data[cmt7]"><?php echo $telaid_employee_data['cmt7'] ?></textarea></td>
									    </tr>
									    <tr>
											<td>Key Observations (AFIs/Strengths):</td>
											<td colspan=3><textarea class="form-control" disabled name="data[key_observations]"><?php echo $telaid_employee_data['key_observations'] ?></textarea></td>
											<td>Action Plan & Commitment:</td>
											<td colspan=4><textarea class="form-control" disabled name="data[action_plan]"><?php echo $telaid_employee_data['action_plan'] ?></textarea></td>
										</tr>
										
										<tr class="eml" style="height:25px; font-weight:bold">
											<td colspan='8' style="text-align:center; background-color:black; color: white;">Consequences in Case of No-Improvement</td>
										</tr>
										<tr>
											<td colspan ='2' rowspan="2">Consequences for the Employee</td>
											<td colspan=6><textarea class="form-control" disabled name="data[employee_consequences]"><?php echo $telaid_employee_data['employee_consequences'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan ='4'>Has the Employee Been Informed About the Consequences?</td>
										    <td>
												<select class="form-control"  id="informed_consequences" name="data[informed_consequences]" disabled style="background-color: rgb(0, 128, 0); color: rgb(0, 0, 0);">
													<option  <?php echo $telaid_employee_data['informed_consequences']=='YES'?"selected":""; ?> value="YES">YES</option>
													<option <?php echo $telaid_employee_data['informed_consequences']=='NO'?"selected":""; ?> value="NO">NO</option>
													<option <?php echo $telaid_employee_data['informed_consequences']=='NA'?"selected":""; ?> value="NA">NA</option>
												</select>
											</td>
										</tr>
										
										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" disabled name="data[call_summary]"><?php echo $telaid_employee_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" disabled name="data[feedback]"><?php echo $telaid_employee_data['feedback'] ?></textarea></td>
										</tr>

										<tr>
											<td>Received and acknowledged by:</td>
											<td colspan=3><textarea class="form-control" id="agent_id_ack" readonly name=""></textarea></td>
											<td>Noted by:</td>
											<td colspan=4><textarea class="form-control" id="coach_ack" readonly name=""><?php echo $telaid_employee_data['coach'] ?></textarea></td>
										</tr>


									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $telaid_employee_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $telaid_employee_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="telaid_employee_id" class="form-control" value="<?php echo $telaid_employee_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $telaid_employee_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $telaid_employee_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $telaid_employee_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($telaid_employee_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($telaid_employee_data['agent_rvw_note']==''){ ?>
													<td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>

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