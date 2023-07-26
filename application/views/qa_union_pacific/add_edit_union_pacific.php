
<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#CA6F1E;
}

input[type='checkbox']{
	width: 20px;
}

#fatalspan3{

	background-color: transparent;
	border: none;
	outline: none;
	color: white;
}

.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if($union_pacific_data_id!=0){
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
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader">Union Pacific Form  </td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>

									<?php
										if ($union_pacific_data_id == 0) {
											$auditorName = get_username();
											//$auditDate = CurrDateMDY();
											$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($union_pacific_data['entry_by'] != '') {
												$auditorName = $union_pacific_data['auditor_name'];
											} else {
												$auditorName = $union_pacific_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($union_pacific_data['call_date']);
											$auditDate = mysql2mmddyySls($union_pacific_data['audit_date']);
										}
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $union_pacific_data['agent_id'];
											$fusion_id = $union_pacific_data['fusion_id'];
											$agent_name = $union_pacific_data['fname'] . " " . $union_pacific_data['lname'] ;
											$tl_id = $union_pacific_data['tl_id'];
											$tl_name = $union_pacific_data['tl_name'];
											$call_duration = $union_pacific_data['call_duration'];
										}
										?>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Employee Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $union_pacific_data['agent_id'] ?>"><?php echo $agent_name; ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $fusion_id; ?>" readonly></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
										</td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" onkeydown="return false;" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
										<td>Call Link:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="data[call_link]" value="<?php echo $union_pacific_data['call_link']; ?>" required></td>
										<td>Account:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  onkeyup="checkDecConsumer(this);" name="data[account]" value="<?php echo $union_pacific_data['account']; ?>" required>
											<span id="start_phone" style="color:red"></span>
										</td>
									</tr>
			
									<tr>
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
												<select class="form-control" id="KPI_ACPT" name="data[KPI_ACPT]" required>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($union_pacific_data['KPI_ACPT']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($union_pacific_data['KPI_ACPT']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($union_pacific_data['KPI_ACPT']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($union_pacific_data['KPI_ACPT']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($union_pacific_data['KPI_ACPT']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
												<option <?php echo $union_pacific_data['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $union_pacific_data['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $union_pacific_data['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $union_pacific_data['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $union_pacific_data['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($union_pacific_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($union_pacific_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($union_pacific_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($union_pacific_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($union_pacific_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($union_pacific_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($union_pacific_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($union_pacific_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($union_pacific_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($union_pacific_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="union_pacific_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $union_pacific_data['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="union_pacific_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $union_pacific_data['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="union_pacific_overall_score" name="data[overall_score]" class="form-control union_pacificFatal" style="font-weight:bold" value="<?php echo $union_pacific_data['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#2471A3; color:white">
										<td colspan=3>Parameters</td>
										<td>Weightage</td>
										<td>Rating</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>1</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Opening</td>
										<td style="background-color:#BFC9CA">12</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Identify himself/herself by first name and state that he/she is calling from Union Pacific or LOUP at the beginning of the call? **SQ**
										(Example: Hi this is Amity calling from Union Pacific)</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF1" name="data[identify_himself]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['identify_himself']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['identify_himself']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['identify_himself']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm1]" class="form-control" value="<?php echo $union_pacific_data['comm1'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Provide the Quality Assurance Statement verbatim, before any specific account information was discussed?**SQ**
										Recording disclosure: "All calls are recorded and may be monitored for Quality Assurance"</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF2" name="data[provide_quality_assurance]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['provide_quality_assurance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['provide_quality_assurance']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['provide_quality_assurance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm2]" class="form-control" value="<?php echo $union_pacific_data['comm2'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Did the agent get caller's name and then use that throughout the call?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[get_callers_name]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['get_callers_name']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['get_callers_name']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['get_callers_name']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm3]" class="form-control" value="<?php echo $union_pacific_data['comm3'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">State the client name and the purpose of the communication?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF3" name="data[purpose_communication]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['purpose_communication']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['purpose_communication']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['purpose_communication']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm4]" class="form-control" value="<?php echo $union_pacific_data['comm4'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Did the rep ask for callback permission as per Reg F policy?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[callback_permission]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['callback_permission']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['callback_permission']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['callback_permission']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm5]" class="form-control" value="<?php echo $union_pacific_data['comm5'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Sate/Ask for balance due?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[balance_due]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['balance_due']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['balance_due']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['balance_due']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm6]" class="form-control" value="<?php echo $union_pacific_data['comm6'] ?>"></td>
									</tr>

									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Effort</td>
										<td style="background-color:#BFC9CA">20</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Ask for a reason for delinquency/intention to resolve the account?</td>
										<td>5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[intention_resolve]" required>
												<option union_pacific_val=5 union_pacific_max="5" <?php echo $union_pacific_data['intention_resolve']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="5" <?php echo $union_pacific_data['intention_resolve']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=5 union_pacific_max="5" <?php echo $union_pacific_data['intention_resolve']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm7]" class="form-control" value="<?php echo $union_pacific_data['comm7'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Full and Complete information taken?
										Examples: Did the agent ask appropriate open/close ended probing questions?</td>
										<td>5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[complete_information]" required>
												<option union_pacific_val=5 union_pacific_max="5" <?php echo $union_pacific_data['complete_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="5" <?php echo $union_pacific_data['complete_information']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=5 union_pacific_max="5" <?php echo $union_pacific_data['complete_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm8]" class="form-control" value="<?php echo $union_pacific_data['comm8'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Followed the previous conversations on the account for the follow-up call</td>
										<td>5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[previous_conversations]" required>
												<option union_pacific_val=5 union_pacific_max="5" <?php echo $union_pacific_data['previous_conversations']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="5" <?php echo $union_pacific_data['previous_conversations']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=5 union_pacific_max="5" <?php echo $union_pacific_data['previous_conversations']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm9]" class="form-control" value="<?php echo $union_pacific_data['comm9'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Able to take a promise to pay on the account by providing banking info as to where the RP can send their payment?</td>
										<td>5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[promise_pay]" required>
												<option union_pacific_val=5 union_pacific_max="5" <?php echo $union_pacific_data['promise_pay']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="5" <?php echo $union_pacific_data['promise_pay']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=5 union_pacific_max="5" <?php echo $union_pacific_data['promise_pay']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm10]" class="form-control" value="<?php echo $union_pacific_data['comm10'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Compliance</td>
										<td style="background-color:#BFC9CA">20</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Did not  Misrepresent their identity or authorization and status of the consumer's account?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF4" name="data[misrepresent_identity]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['misrepresent_identity']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['misrepresent_identity']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['misrepresent_identity']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm11]" class="form-control" value="<?php echo $union_pacific_data['comm11'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Did not Discuss or imply that any type of legal actions - will be taken or property repossessed, also on time barred accounts amd Did not Threaten to take actions that VRS or the client cannot legally take? </td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF5" name="data[imply_leagal_actions]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['imply_leagal_actions']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['imply_leagal_actions']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['imply_leagal_actions']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm12]" class="form-control" value="<?php echo $union_pacific_data['comm12'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Did not Make any false representations regarding the nature of the communication?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF6" name="data[nature_of_communication]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['nature_of_communication']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['nature_of_communication']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['nature_of_communication']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm13]" class="form-control" value="<?php echo $union_pacific_data['comm13'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 5:00 pm CST?
										Note: Avoid calling customer's personal phone during evening/nightime.</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF7" name="data[contact_consumer]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['contact_consumer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['contact_consumer']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['contact_consumer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm14]" class="form-control" value="<?php echo $union_pacific_data['comm14'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Did not Communicate with the consumer after learning the consumer is represented by an attorney, filed for bankruptcy unless a permissible reason exists?
										(account should be escalated back to UP if this conversation has occurred)</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF8" name="data[communicate_consumer]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['communicate_consumer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['communicate_consumer']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['communicate_consumer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm15]" class="form-control" value="<?php echo $union_pacific_data['comm15'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF9" name="data[status_code]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['status_code']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['status_code']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['status_code']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm16]" class="form-control" value="<?php echo $union_pacific_data['comm16'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Did not Make any statement that could constitute unfair, deceptive, or abusive acts or practices that may raise UDAAP concerns?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF10" name="data[abusive_acts]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['abusive_acts']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['abusive_acts']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['abusive_acts']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm17]" class="form-control" value="<?php echo $union_pacific_data['comm17'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF11" name="data[false_credit_information]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['false_credit_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['false_credit_information']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['false_credit_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm18]" class="form-control" value="<?php echo $union_pacific_data['comm18'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint, or offer to escalate the call?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF12" name="data[take_appropriate_action]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['take_appropriate_action']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['take_appropriate_action']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['take_appropriate_action']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm19]" class="form-control" value="<?php echo $union_pacific_data['comm19'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Did not Make any statement that could be considered discriminatory towards a consumer or a violation of VRS ECOA policy?</td>
										<td>2</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF13" name="data[violation_ECOA_policy]" required>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['violation_ECOA_policy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2" <?php echo $union_pacific_data['violation_ECOA_policy']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2 union_pacific_max="2" <?php echo $union_pacific_data['violation_ECOA_policy']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm20]" class="form-control" value="<?php echo $union_pacific_data['comm20'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>4</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Verification</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Demonstrate Active Listening?</td>
										<td>2.5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[active_listening]" required>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2.5" <?php echo $union_pacific_data['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm21]" class="form-control" value="<?php echo $union_pacific_data['comm21'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Anticipate and overcome objections?</td>
										<td>2.5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[overcome_objections]" required>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['overcome_objections']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2.5" <?php echo $union_pacific_data['overcome_objections']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['overcome_objections']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm22]" class="form-control" value="<?php echo $union_pacific_data['comm22'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Did the collector get connected with the consumer by building a rapport?</td>
										<td>2.5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[building_rapport]" required>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['building_rapport']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2.5" <?php echo $union_pacific_data['building_rapport']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['building_rapport']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm23]" class="form-control" value="<?php echo $union_pacific_data['comm23'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Did the collector use system appropriately?
										Examples: Appropriate usage of system to provide accurate information / to provide a breakdown of balance (as required)</td>
										<td>2.5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[use_system_appropriately]" required>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['use_system_appropriately']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2.5" <?php echo $union_pacific_data['use_system_appropriately']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['use_system_appropriately']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm24]" class="form-control" value="<?php echo $union_pacific_data['comm24'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>5</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Soft Skills / Telephone Etiquettes</td>
										<td style="background-color:#BFC9CA">16</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Offer any apologies/empathy statement on RP's unfortunate situation</td>
										<td>4</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[empathy_statement]" required>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['empathy_statement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="4" <?php echo $union_pacific_data['empathy_statement']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['empathy_statement']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm25]" class="form-control" value="<?php echo $union_pacific_data['comm25'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Did collector hung up on RP? / Did collector interrupt or talked over RP? / Did collector has disrespectful attitude/tone?</td>
										<td>4</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[hung_up_RP]" required>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['hung_up_RP']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="4" <?php echo $union_pacific_data['hung_up_RP']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['hung_up_RP']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm26]" class="form-control" value="<?php echo $union_pacific_data['comm26'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Did the agent avoid dead air on the call? Instead place on hold if necessary</td>
										<td>4</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[dead_air]" required>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['dead_air']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="4" <?php echo $union_pacific_data['dead_air']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['dead_air']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm27]" class="form-control" value="<?php echo $union_pacific_data['comm27'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Was the collector tone pleasant and accommodating? / Was the collector tone came across as confident and sounded knowledable?</td>
										<td>4</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[pleasant_tone]" required>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['pleasant_tone']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="4" <?php echo $union_pacific_data['pleasant_tone']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['pleasant_tone']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm28]" class="form-control" value="<?php echo $union_pacific_data['comm28'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>6</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Closing</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Summarize the call?</td>
										<td>2.5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[summarize_call]" required>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['summarize_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2.5" <?php echo $union_pacific_data['summarize_call']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['summarize_call']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm29]" class="form-control" value="<?php echo $union_pacific_data['comm29'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Provided UP / LOUP call back number?</td>
										<td>2.5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[provided_UP]" required>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['provided_UP']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2.5" <?php echo $union_pacific_data['provided_UP']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['provided_UP']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm30]" class="form-control" value="<?php echo $union_pacific_data['comm30'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Set appropriate timelines and expectations for follow up?</td>
										<td>2.5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[follow_up]" required>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['follow_up']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2.5" <?php echo $union_pacific_data['follow_up']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['follow_up']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm31]" class="form-control" value="<?php echo $union_pacific_data['comm31'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Close the call Professionally with proper greeting? / Did collector ask if there are any further questions? </td>
										<td>2.5</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[proper_greeting]" required>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['proper_greeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="2.5" <?php echo $union_pacific_data['proper_greeting']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=2.5 union_pacific_max="2.5" <?php echo $union_pacific_data['proper_greeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm32]" class="form-control" value="<?php echo $union_pacific_data['comm32'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>7</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Documentation</td>
										<td style="background-color:#BFC9CA">12</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Document thoroughly the context of the conversation?
										Examples: All the important information happened during the conversation; Payment Promise information; Update information if changing the phone number; Update information if change staus is required. </td>
										<td>4</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF14" name="data[context_conversation]" required>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['context_conversation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="4" <?php echo $union_pacific_data['context_conversation']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['context_conversation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm33]" class="form-control" value="<?php echo $union_pacific_data['comm33'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Remove any phone numbers known to be incorrect?**SQ** </td>
										<td>4</td>
										<td>
											<select class="form-control union_pacific_point" id="union_pacificAF15" name="data[remove_phone_no]" required>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['remove_phone_no']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="4" <?php echo $union_pacific_data['remove_phone_no']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['remove_phone_no']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm34]" class="form-control" value="<?php echo $union_pacific_data['comm34'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Escalate the account to a supervisor for handling, if appropriate? / If required, for further account handling escalate it to Union Pacific / LOUP.</td>
										<td>4</td>
										<td>
											<select class="form-control union_pacific_point" id="" name="data[escalate_account]" required>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['escalate_account']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option union_pacific_val=0 union_pacific_max="4" <?php echo $union_pacific_data['escalate_account']=='No'?"selected":""; ?> value="No">No</option>
												<option union_pacific_val=4 union_pacific_max="4" <?php echo $union_pacific_data['escalate_account']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm35]" class="form-control" value="<?php echo $union_pacific_data['comm35'] ?>"></td>
									</tr>

									<tr>
										<td>Observations:</td>
										<td colspan=2><textarea class="form-control"  name="data[call_summary]"><?php echo $union_pacific_data['call_summary'] ?></textarea></td>
										<td>Area of opportunity:</td>
										<td colspan=2><textarea class="form-control"  name="data[feedback]"><?php echo $union_pacific_data['feedback'] ?></textarea></td>
									</tr>
									<?php if($union_pacific_data_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($union_pacific_data['attach_file']!=''){ ?>
											<td colspan=4>
												<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
												<?php $attach_file = explode(",",$union_pacific_data['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
											  }
										} ?>
									</tr>
										
									<?php if($union_pacific_data_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $union_pacific_data['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $union_pacific_data['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $union_pacific_data['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
										
									<?php 
									if($union_pacific_data_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($union_pacific_data['entry_date'],72) == true){ ?>
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
