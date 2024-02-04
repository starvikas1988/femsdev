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

<?php if ($final_pmo_id != 0) {
	if (is_access_qa_edit_feedback() == false) { ?>
		<style>
			.form-control {
				pointer-events: none;
				background-color: #D5DBDB;
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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">Telaid Employee Coaching Form</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($final_pmo_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($employee_coaching_telaid['entry_by'] != '') {
												$auditorName = $employee_coaching_telaid['auditor_name'];
											} else {
												$auditorName = $employee_coaching_telaid['client_name'];
											}
										
											$auditDate = mysql2mmddyy($employee_coaching_telaid['audit_date']);
										 
											//$clDate_val = mysql2mmddyy($employee_coaching_telaid['call_date']);
										}

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											//$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $employee_coaching_telaid['agent_id'];
											$fusion_id = $employee_coaching_telaid['fusion_id'];
											$agent_name = $employee_coaching_telaid['fname'] . " " . $employee_coaching_telaid['lname'] ;
											$tl_id = $employee_coaching_telaid['tl_id'];
											$tl_name = $employee_coaching_telaid['tl_name'];
											//$call_duration = $employee_coaching_telaid['call_duration'];
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Account:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="" name="account"  readonly value="Telaid" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
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
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
											</td>
										</tr>
										<tr>
											<td>LOB:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[lob]" required>
											    <option value="">-Select-</option>
											    <option value="HD 1.1" <?= ($employee_coaching_telaid['lob']=="HD 1.1")?"selected":"" ?>>HD 1.1</option>
												<option value="HD 1.2" <?= ($employee_coaching_telaid['lob']=="HD 1.2")?"selected":"" ?>>HD 1.2</option>
												<option value="HD 1.3" <?= ($employee_coaching_telaid['lob']=="HD 1.3")?"selected":"" ?>>HD 1.3</option>
												<option value="PM 1.1" <?= ($employee_coaching_telaid['lob']=="PM 1.1")?"selected":"" ?>>PM 1.1</option>
												<option value="PM 1.2" <?= ($employee_coaching_telaid['lob']=="PM 1.2")?"selected":"" ?>>PM 1.2</option>
												<option value="AP 1.1" <?= ($employee_coaching_telaid['lob']=="AP 1.1")?"selected":"" ?>>AP 1.1</option>
												<option value="SD 1.2" <?= ($employee_coaching_telaid['lob']=="SD 1.2")?"selected":"" ?>>SD 1.2</option>
										</select>
											</td>
											<td>Form No:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[form_no]" value="T001" readonly>
											</td>

											<td>Coach:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id='coach' name="data[coach]" value="<?php echo $employee_coaching_telaid['coach'] ?>" required>
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
												if($employee_coaching_telaid['poor_job_performance']=='Severe'){
													?>
													<select class="form-control"  id="poor_job_performance" name="data[poor_job_performance]" required style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="poor_job_performance" name="data[poor_job_performance]" required>
													<?php
												}
												?>
												
													<option <?php echo $employee_coaching_telaid['poor_job_performance']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $employee_coaching_telaid['poor_job_performance']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $employee_coaching_telaid['poor_job_performance']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $employee_coaching_telaid['poor_job_performance']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $employee_coaching_telaid['poor_job_performance']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" name="data[cmt1]"><?php echo $employee_coaching_telaid['cmt1'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Violation of Procedural Guidelines</td>
											<td>
												<?php
												if($employee_coaching_telaid['procedural_guidelines']=='Severe'){
													?>
													<select class="form-control"  id="procedural_guidelines" name="data[procedural_guidelines]" required style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="procedural_guidelines" name="data[procedural_guidelines]" required>
													<?php
												}
												?>	
													<option <?php echo $employee_coaching_telaid['procedural_guidelines']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $employee_coaching_telaid['procedural_guidelines']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $employee_coaching_telaid['procedural_guidelines']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $employee_coaching_telaid['procedural_guidelines']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $employee_coaching_telaid['procedural_guidelines']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" name="data[cmt2]"><?php echo $employee_coaching_telaid['cmt2'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Behavioral</td>
											<td>
												<?php
												if($employee_coaching_telaid['behavioral']=='Severe'){
													?>
													<select class="form-control"  id="behavioral" name="data[behavioral]" required style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="behavioral" name="data[behavioral]" required>
													<?php
												}
												?>	
													<option <?php echo $employee_coaching_telaid['behavioral']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $employee_coaching_telaid['behavioral']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $employee_coaching_telaid['behavioral']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $employee_coaching_telaid['behavioral']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $employee_coaching_telaid['behavioral']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" name="data[cmt3]"><?php echo $employee_coaching_telaid['cmt3'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Attendance Infraction</td>
											<td>
												<?php
												if($employee_coaching_telaid['attendance_infraction']=='Severe'){
													?>
													<select class="form-control"  id="attendance_infraction" name="data[attendance_infraction]" required style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="attendance_infraction" name="data[attendance_infraction]" required>
													<?php
												}
												?>	
													<option <?php echo $employee_coaching_telaid['attendance_infraction']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $employee_coaching_telaid['attendance_infraction']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $employee_coaching_telaid['attendance_infraction']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $employee_coaching_telaid['attendance_infraction']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $employee_coaching_telaid['attendance_infraction']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" name="data[cmt4]"><?php echo $employee_coaching_telaid['cmt4'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Changed Work Scenario</td>
											<td>
												<?php
												if($employee_coaching_telaid['work_scenario']=='Severe'){
													?>
													<select class="form-control"  id="work_scenario" name="data[work_scenario]" required style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="work_scenario" name="data[work_scenario]" required>
													<?php
												}
												?>	
													<option <?php echo $employee_coaching_telaid['work_scenario']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $employee_coaching_telaid['work_scenario']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $employee_coaching_telaid['work_scenario']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $employee_coaching_telaid['work_scenario']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $employee_coaching_telaid['work_scenario']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" name="data[cmt5]"><?php echo $employee_coaching_telaid['cmt5'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>Others (Please specify) Sleeping on Shift</td>
											<td>
												<?php
												if($employee_coaching_telaid['sleeping_shift']=='Severe'){
													?>
													<select class="form-control"  id="sleeping_shift" name="data[sleeping_shift]" required style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="sleeping_shift" name="data[sleeping_shift]" required>
													<?php
												}
												?>	
													<option <?php echo $employee_coaching_telaid['sleeping_shift']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $employee_coaching_telaid['sleeping_shift']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $employee_coaching_telaid['sleeping_shift']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $employee_coaching_telaid['sleeping_shift']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $employee_coaching_telaid['sleeping_shift']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" name="data[cmt6]"><?php echo $employee_coaching_telaid['cmt6'] ?></textarea></td>
									    </tr>
									    <tr>
											<td colspan='4'>None</td>
											<td>
												<?php
												if($employee_coaching_telaid['none']=='Severe'){
													?>
													<select class="form-control"  id="none" name="data[none]" required style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
													<?php
												}else{
													?>
													<select class="form-control"  id="none" name="data[none]" required>
													<?php
												}
												?>	
													<option <?php echo $employee_coaching_telaid['none']=='Critical'?"selected":""; ?> value="Critical">Critical</option>
													<option <?php echo $employee_coaching_telaid['none']=='Severe'?"selected":""; ?> value="Severe">Severe</option>
													<option <?php echo $employee_coaching_telaid['none']=='Average'?"selected":""; ?> value="Average">Average</option>
													<option <?php echo $employee_coaching_telaid['none']=='Mild'?"selected":""; ?> value="Mild">Mild</option>
													<option <?php echo $employee_coaching_telaid['none']=='Low'?"selected":""; ?> value="Low">Low</option>
												</select>
											</td>
											<td colspan="2"> <textarea class="form-control" name="data[cmt7]"><?php echo $employee_coaching_telaid['cmt7'] ?></textarea></td>
									    </tr>
									    <tr>
											<td>Key Observations (AFIs/Strengths):</td>
											<td colspan=3><textarea class="form-control" name="data[key_observations]"><?php echo $employee_coaching_telaid['key_observations'] ?></textarea></td>
											<td>Action Plan & Commitment:</td>
											<td colspan=4><textarea class="form-control" name="data[action_plan]"><?php echo $employee_coaching_telaid['action_plan'] ?></textarea></td>
										</tr>
										
										<tr class="eml" style="height:25px; font-weight:bold">
											<td colspan='8' style="text-align:center; background-color:black; color: white;">Consequences in Case of No-Improvement</td>
										</tr>
										<tr>
											<td colspan ='2' rowspan="2">Consequences for the Employee</td>
											<td colspan=6><textarea class="form-control" name="data[employee_consequences]"><?php echo $employee_coaching_telaid['employee_consequences'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan ='4'>Has the Employee Been Informed About the Consequences?</td>
										    <td>
												<select class="form-control"  id="informed_consequences" name="data[informed_consequences]" required style="background-color: rgb(0, 128, 0); color: rgb(0, 0, 0);">
													<option  <?php echo $employee_coaching_telaid['informed_consequences']=='YES'?"selected":""; ?> value="YES">YES</option>
													<option <?php echo $employee_coaching_telaid['informed_consequences']=='NO'?"selected":""; ?> value="NO">NO</option>
													<option <?php echo $employee_coaching_telaid['informed_consequences']=='NA'?"selected":""; ?> value="NA">NA</option>
												</select>
											</td>
										</tr>
										
										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" name="data[call_summary]"><?php echo $employee_coaching_telaid['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $employee_coaching_telaid['feedback'] ?></textarea></td>
										</tr>

										<tr>
											<td>Received and acknowledged by:</td>
											<td colspan=3><textarea class="form-control" id="agent_id_ack" readonly name=""></textarea></td>
											<td>Noted by:</td>
											<td colspan=4><textarea class="form-control" id="coach_ack" readonly name=""><?php echo $employee_coaching_telaid['coach'] ?></textarea></td>
										</tr>

										<?php if ($final_pmo_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=6><?php echo $employee_coaching_telaid['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $employee_coaching_telaid['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $employee_coaching_telaid['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $employee_coaching_telaid['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($final_pmo_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($employee_coaching_telaid['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="8"><button class="btn btn-success blains-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
													</tr>
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