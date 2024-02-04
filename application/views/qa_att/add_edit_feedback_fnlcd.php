<script src="<?php echo base_url() ?>application/third_party/ckeditor/ckeditor.js"></script>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
	.container{
		margin-top: 20px;
		font-family: 'Roboto', sans-serif;
	}
	.card {
	  position: relative;
	  display: flex;
	  flex-direction: column;
	  min-width: 0;
	  word-wrap: break-word;
	  background-color: #fff;
	  background-clip: border-box;
	  border: 1px solid rgba(0, 0, 0, 0.125);
	  border-radius: 0.25rem;
	  box-shadow: 0 2px 6px 0 rgba(32,33,37,.1);
	}
	.card-header {
	  padding: 0.5rem 1rem;
	  margin-bottom: 0;
	  background-color: rgba(0, 0, 0, 0.03);
	  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
	  padding: 15px;
		background-color: #3b5998;
		color: #fff;
	}
	.header{
		font-family: 'Roboto', sans-serif;
		font-weight: 900;
		font-size: 16px;
		text-transform: capitalize;
		letter-spacing: 1px;
	}
	.card-body {
	  flex: 1 1 auto;
	  padding: 1rem 1rem;
	}
	.form-control{
		height: 40px!important;
		border-radius: 0px!important;
		transition: all 0.3s ease;
	}
	.form-control:focus {
		border-color: #3b5998;
		box-shadow: none!important;
	}
		
		
	
	.common-space{
	  margin-bottom: 10px;
	}
	textarea
	{
		width: 100%;
		max-width: 100%;
	}
	.table tbody th.scope {
	  background: #e8ebf8;
	  border-bottom: 1px solid #e0e5f6;
	}

	/*background: #eef2f5;*/
	.btn-save
	{
		width: 150px;
		border-radius: 1px;
		background: #3b5998;
		color: #fff;
		transition: all 0.3s ease;

	}
	.btn.focus, .btn:focus, .btn:hover {
	  color: #fff;
	  text-decoration: none;
	  background: #2a5cc4;
	  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .25), 0 3px 10px 5px rgba(0, 0, 0, 0.05) !important;

	}
	.table > thead > tr > th {
	  vertical-align: bottom;
	  border-bottom: 1px solid #ddd;
	  background: #3b5998;
	  color: #fff;
	  padding: 15px;
	}
	.table tbody th.scope {
	  background: #3b5998;
	  border-bottom: 1px solid #e0e5f6;
	  color: #fff;
	  text-align: center;
	  padding: 15px;
	}
	.table th,td{
		text-align: center;
		padding-top: 15px;
	}
	.margin-Right
	{
		margin-right: -20px;
	}
	.paddingTop
	{
		padding-top: 15px!important;
	}
	.fa-shield
	{
		margin-right: 5px;
		font-size: 18px;
	}

	.box_wrap{
	width: 250px;
	font-family: Arial;
	white-space: pre-wrap;
}
</style>
<style>
input{

	text-align:center;
}

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.eml{
	font-weight:bold;
	background-color:#D4EFDF;
}

select {
  text-align: center;
  text-align-last: center;
  /* webkit*/
}
option {
  text-align: left;
  /* reset to left*/
}

textarea{
	text-align: center;
  text-align-last: center;
}

<style> 
	.nps_panel, .nps_flip, .aht_panel, .aht_flip, .revenue_panel, .revenue_flip, .compl_panel, .compl_flip, .noncust_panel, .noncust_flip, .keyper_panel, .keyper_flip {
	  padding: 5px;
	  text-align: center;
	  background-color: #e5eecc;
	  border: solid 1px #c3c3c3;
	}

	.nps_panel, .aht_panel, .revenue_panel, .compl_panel, .noncust_panel, .keyper_panel {
	  padding: 50px;
	  display: none;
	}

	.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}
</style>

</style>
<?php if($att_id!=0){
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
				  	<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="12" id="theader" style="font-size:30px">AT&T 5 Step Coaching Form 
											<button style="background-color: green; color: white; padding: 10px 20px; border: none; cursor: pointer;">
											    <a href="<?php echo base_url() ?>qa_files/qa_att/5_Steps_of_Coaching.jpg" target="_blank" style="text-decoration: none; color: inherit;">Tool Tips</a>
											</button>
										</td>
									</tr>
									<?php
										if($att_id==0){
											$auditorName = get_username();
											$auditDate =  CurrDateMDY(); //date("m-d-Y",time());
											$clDate_val='';
											$tl_name = '';
											$tl_id='';
										}else{
												if($auditData['entry_by']!=''){
													$auditorName = $auditData['auditor_name'];
												}else{
													$auditorName = $auditData['client_name'];
												}
												$auditDate = mysql2mmddyy($auditData['audit_date']);
												$clDate_val = mysqlDt2mmddyy($auditData['follow_up_date']);
												$sel='';
												$tl_name = $auditData['tl_name'];
												$tl_id = $auditData['tl_id'];
										}
									?>
									<tr>
										<td colspan='1'>QA Name:</td>
										<td colspan='2'><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td colspan='2'>Client:</td>
										<td colspan='2'>
											<input type="text" readonly class="form-control" id="" name="client" value="<?php echo $client['fullname']; ?>">
										</td>
										<td colspan='2'>Process:</td>
										<td colspan='3'>
											<select class="form-control" style="text-align:center" id="process_client" name="data[process_id]" required>
												<option value="">-Select-</option>
												<?php 

												foreach ($process as $key => $value){ 
													if($value['id'] == $auditData['process_id']){
														$sel = 'selected';

													}else{
														$sel='';
													}
													?>
												<option value="<?php echo $value['id'] ?>" <?=$sel; ?>><?php echo $value['name'] ?></option>
											<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan='1'>Agent:</td>
										<td colspan='2'>
											<select class="form-control" style="text-align:center" id="agent_id" name="data[agent_id]" required>
												<?php if($auditData['agent_id']!=''){ ?>
												<option value="<?php echo $auditData['agent_id']; ?>"><?php echo $auditData['agent_name']."-(".$auditData['fusion_id'].")"; ?></option>
												<?php }?>
												<option value="">-Select-</option>
											</select>
										</td>
										<td colspan='2'>Employee ID:</td>
										<td colspan='2'><input type="text" readonly class="form-control" id="fusion_id" name="data[employee_id]" value="<?php echo $auditData['fusion_id'] ?>"></td>
										
										<td colspan='2'>L1 Supervisor:</td>
										<td colspan='3'>
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
										</td>
									</tr>
									<tr>	
										<td colspan='1'>Audit Date:</td>
										<td colspan='2'><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
									</tr>
									<tr  style="height:25px; font-weight:bold">
											<td colspan='12' style="text:center; background-color:black; color: white;">MTD</td>
										</tr>
										<tr>
											<td colspan="1">QA:</td>
											<td colspan="1"><input type="text" class="form-control" name="data[mtd_qa]" value="<?php echo $auditData['mtd_qa'] ?>"></td>

											<td colspan="2">Tcrift:</td>
											<td colspan="2"><input type="text" class="form-control" name="data[mtd_tcrift]" value="<?php echo $auditData['mtd_tcrift'] ?>"></td>

											<td colspan="2">AHT:</td>
											<td colspan="3"><input type="text" class="form-control" name="data[mtd_aht]" value="<?php echo $auditData['mtd_aht'] ?>"></td>
										</tr>

										<tr>
											<td colspan="1">Attendance :</td>
											<td colspan="1"><input type="text" class="form-control" name="data[mtd_attendance]" value="<?php echo $auditData['mtd_attendance'] ?>"></td>

											<td colspan="2">Saves:</td>
											<td colspan="2"><input type="text" class="form-control" name="data[mtd_saves]" value="<?php echo $auditData['mtd_saves'] ?>"></td>

											<td colspan="2">Compliance:</td>
											<td colspan="3"><input type="text" class="form-control" name="data[mtd_compliance]" value="<?php echo $auditData['mtd_compliance'] ?>"></td>

										</tr>
										<tr style="height:25px; font-weight:bold">
											<td colspan='12' style="text:center; background-color:black; color: white;">WTD</td>
										</tr>
										<tr>
											<td colspan="1">QA:</td>
											<td colspan="1"><input type="text" class="form-control" name="data[wtd_qa]" value="<?php echo $auditData['wtd_qa'] ?>"></td>

											<td colspan="2">Tcrift:</td>
											<td colspan="2"><input type="text" class="form-control" name="data[wtd_tcrift]" value="<?php echo $auditData['wtd_tcrift'] ?>"></td>

											<td colspan="2">AHT:</td>
											<td colspan="3"><input type="text" class="form-control" name="data[wtd_aht]" value="<?php echo $auditData['wtd_aht'] ?>"></td>
										</tr>
												
										<tr>
											<td colspan="1">Attendance :</td>
											<td colspan="1"><input type="text" class="form-control" name="data[wtd_attendance]" value="<?php echo $auditData['wtd_attendance'] ?>"></td>

											<td colspan="2">Saves:</td>
											<td colspan="2"><input type="text" class="form-control" name="data[wtd_saves]" value="<?php echo $auditData['wtd_saves'] ?>"></td>

											<td colspan="2">Compliance:</td>
											<td colspan="3"><input type="text" class="form-control" name="data[wtd_compliance]" value="<?php echo $auditData['wtd_compliance'] ?>" ></td>

										</tr>
										
										<tr>
											<td colspan="2">Current Focused KPI/Behavior:</td>
											<td colspan="2">
											<select class="form-control" id="" name="data[current_kpi_behavior]">
											    <option value="">-Select-</option>
											    <option <?php echo $auditData['prior_kpi_behavior'] == "Sales" ? "selected" : ""; ?> value="Sales">Sales</option>
											    <option <?php echo $auditData['current_kpi_behavior'] == "Sales" ? "selected" : ""; ?> value="Sales">Sales</option>
											    <option <?php echo $auditData['current_kpi_behavior'] == "Saves" ? "selected" : ""; ?> value="Saves">Saves</option>
											    <option <?php echo $auditData['current_kpi_behavior'] == "ORS" ? "selected" : ""; ?> value="ORS">ORS</option>
											    <option <?php echo $auditData['current_kpi_behavior'] == "AHT" ? "selected" : ""; ?> value="AHT">AHT</option>
											    <option <?php echo $auditData['current_kpi_behavior'] == "Attendance" ? "selected" : ""; ?> value="Attendance">Attendance</option>
											    <option <?php echo $auditData['current_kpi_behavior'] == "Compliance" ? "selected" : ""; ?> value="Compliance">Compliance</option>
											    <option <?php echo $auditData['current_kpi_behavior'] == "K&E" ? "selected" : ""; ?> value="K&E">K&E</option>
											    <option <?php echo $auditData['current_kpi_behavior'] == "7Day Repeate" ? "selected" : ""; ?> value="7Day Repeate">7Day Repeate</option>
											    <option <?php echo $auditData['current_kpi_behavior'] == "Transfers" ? "selected" : ""; ?> value="Transfers">Transfers</option>
											</select>

										</td>

										<td colspan="2">Prior Focused<br>KPI/Behavior:</td>
										<td colspan="6">
											<select class="form-control" id="" name="data[prior_kpi_behavior]">
										    <option value="">-Select-</option>
										    <option <?php echo $auditData['prior_kpi_behavior'] == "Saves" ? "selected" : ""; ?> value="Saves">Saves</option>
										    <option <?php echo $auditData['prior_kpi_behavior'] == "ORS" ? "selected" : ""; ?> value="ORS">ORS</option>
										    <option <?php echo $auditData['prior_kpi_behavior'] == "AHT" ? "selected" : ""; ?> value="AHT">AHT</option>
										    <option <?php echo $auditData['prior_kpi_behavior'] == "Attendance" ? "selected" : ""; ?> value="Attendance">Attendance</option>
										    <option <?php echo $auditData['prior_kpi_behavior'] == "Compliance" ? "selected" : ""; ?> value="Compliance">Compliance</option>
										    <option <?php echo $auditData['prior_kpi_behavior'] == "K&E" ? "selected" : ""; ?> value="K&E">K&E</option>
										    <option <?php echo $auditData['prior_kpi_behavior'] == "7Day Repeate" ? "selected" : ""; ?> value="7Day Repeate">7Day Repeate</option>
										    <option <?php echo $auditData['prior_kpi_behavior'] == "Transfers" ? "selected" : ""; ?> value="Transfers">Transfers</option>
										</select>

										</td>

										</tr>
									
									<tr  style="height:25px; font-weight:bold">
											<td colspan='12' style="text:center; background-color:black; color: white;">Areas of Strength</td>
									</tr>
										<tr>		
											<td colspan='12'>
												<textarea class="form-control" name="data[area_of_strength]"><?php echo $auditData['area_of_strength'] ?></textarea>
											</td>
										</tr>

										<tr  style="height:25px; font-weight:bold">
											<td colspan='12' style="text:center; background-color:black; color: white;">Areas of Opportunity</td>
										</tr>
										<tr colspan='12'>
											<td colspan='6'>What behavior(s) need to be applied, changed, or improved on calls? </td>
											<td colspan='6'>
												<textarea class="form-control" name="data[improve_behavior]"><?php echo $auditData['improve_behavior'] ?></textarea>
											</td>
											</tr>
										<tr colspan='12'>
											<td colspan='6'> The importance of why we need to incorporate this behavior?<br>(Impact to the employee, Customer, and Company)</td>
											<td colspan='6'>
												<textarea class="form-control" name="data[incorporate_behavior]"><?php echo $auditData['incorporate_behavior'] ?></textarea>
											</td>
											</tr>
										<tr colspan='12'>
											<td colspan='6'>What does fulfilling this behavior sound like when speaking to the customer?<br>(Roleplay this with the Employee)</td>
											<td colspan='6'>
												<textarea class="form-control" name="data[fulfilling_behavior]"><?php echo $auditData['fulfilling_behavior'] ?></textarea>
											</td>

											
										</tr>


										<tr  style="height:25px; font-weight:bold">
											<td colspan='4' style="text:center; background-color:black; color: white;">Validation</td>
											<td colspan='2' style="text:center; background-color:black; color: white;">Status</td>
											<td colspan='6' style="text:center; background-color:black; color: white;">Comment</td>
										</tr>
										<tr  style="height:25px; font-weight:bold">
											<td colspan='4' >Did the Sup Demonstrate how the Behavior needs to be<br> fulfilled to the Agent?</td>
											<td colspan='2'>
												<select class="form-control" id="" name="data[validation_sup_behavior]" required>
													<option value="">-Select-</option>
													<option value="Yes" <?= ($auditData['validation_sup_behavior']=="Yes")?"selected":"" ?>>Yes</option>
													<option value="No" <?= ($auditData['validation_sup_behavior']=="No")?"selected":"" ?>>No</option>
												</select>
											</td>

											<td colspan='6'>
												<input type="text" class="form-control" name="data[validation_comm1]" value="<?php echo $auditData['validation_comm1'] ?>">
											</td>

										</tr>
										<tr  style="height:25px; font-weight:bold">
											<td colspan='4' >Did the Sup Observe the Agent Demonstrate the behavior<br> properly? </td>
											<td colspan='2'>
												<select class="form-control" id="" name="data[validation_agent_behavior]" required>
													<option value="">-Select-</option>
													<option value="Yes" <?= ($auditData['validation_agent_behavior']=="Yes")?"selected":"" ?>>Yes</option>
													<option value="No" <?= ($auditData['validation_agent_behavior']=="No")?"selected":"" ?>>No</option>
												</select>
											</td>
											<td colspan='6'><input type="text" class="form-control" name="data[validation_comm2]" value="<?php echo $auditData['validation_comm2'] ?>"></td>
										</tr>
										<tr  style="height:25px; font-weight:bold">
											<td colspan='4' >Did the Sup Roleplay a scenario where this behavior can be<br>	applied?</td>
											<td colspan='2'>
												<select class="form-control" id="" name="data[validation_applied_behavior]" required>
													<option value="">-Select-</option>
													<option value="Yes" <?= ($auditData['validation_applied_behavior']=="Yes")?"selected":"" ?>>Yes</option>
													<option value="No" <?= ($auditData['validation_applied_behavior']=="No")?"selected":"" ?>>No</option>
												</select>
											</td>
											<td colspan='6'><input type="text" class="form-control" name="data[validation_comm3]" value="<?php echo $auditData['validation_comm3'] ?>"></td>
										</tr>
										<tr  style="height:25px; font-weight:bold">
											<td colspan='4' >Did the Sup Check for Understanding and Clarify<br> Expectations?</td>
											<td colspan='2'>
												<select class="form-control" id="" name="data[validation_clarify_expectations]" required>
													<option value="">-Select-</option>
													<option value="Yes" <?= ($auditData['validation_clarify_expectations']=="Yes")?"selected":"" ?>>Yes</option>
													<option value="No" <?= ($auditData['validation_clarify_expectations']=="No")?"selected":"" ?>>No</option>
												</select>
											</td>
											<td colspan='6'><input type="text" class="form-control" name="data[validation_comm4]" value="<?php echo $auditData['validation_comm4'] ?>"></td>
										</tr>

										<tr  style="height:25px; font-weight:bold">
											<td colspan='12' style="text:center; background-color:black; color: white;">Agent Commitments</td>
											
										</tr>
										<tr  style="height:25px; font-weight:bold">
											<td colspan='6' >What actionable items/commitments are you going to make in order to overcome your<br>area of opportunity: </td>
											<td colspan='6'><input type="text" class="form-control" name="data[agent_commitents]" value="<?php echo $auditData['agent_commitents'] ?>" ></td>
											
										</tr>
									
									<tr>
											<td colspan=3>Employee Signature :</td>
											<td colspan=3>
												<input type="text" readonly class="form-control" id="agent_id_ack" name="" value="<?php echo $auditDate; ?>" readonly>
											</td>
											<td colspan=3>Date:</td>
											<td colspan=3>
												<input type="text" class="form-control" id="" required value="<?php echo $auditDate; ?>" readonly>
											</td>
									</tr>
									<tr>
											<td colspan=3>Manager Signature:</td>
											<td colspan=3>
												<input type="text" class="form-control" id="tl_name_id_ack"  value="<?php echo $auditData['tl_name'] ?>"readonly>
											</td>
											<td colspan=3>Date:</td>
											<td colspan=4>
												<input type="text" class="form-control" id="" required value="<?php echo CurrDateMDY() ?>" readonly>
											</td>
									</tr>
									
								
										<?php
										if($auditData['follow_up_active_listening']!=''){
											?>
												<tr class="" style="height:25px; font-weight:bold;">
											    <td colspan='12' style="text:center; background-color:black; color: white;">Follow-up Section</td>
											</tr>

											    <!-- Follow-up form fields go here -->
											    <tr class="">
															<td colspan="2">Follow-up Actions - What are you listening for?:</td>
															<td colspan="2"><input type="text" class="form-control" id="follow_up_active_listening" name="data[follow_up_active_listening]" value="<?php echo $auditData['follow_up_active_listening'] ?>"></td>

															<td colspan="2">When - Date & Time:</td>
															<td colspan="2">
																<input type="text" class="form-control" id="call_date_time" name="follow_up_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>">
															</td>

															<td colspan="2">How:</td>
															<td colspan="2"><input type="text" class="form-control" id="follow_up_how" name="data[follow_up_how]" value="<?php echo $auditData['follow_up_how'] ?>"></td>
														</tr>

														<tr  class="" style="height:25px; font-weight:bold;">
															<td colspan='12' style="text:center; background-color:black; color: white;">Follow-up Results</td>
													 </tr>
													 <tr class="">
													 	<td colspan="4">What was the outcome after the follow up inspection? Did we hear the desired behaviors based on the actions/commitments provided by agent in the last coaching session on the phone?</td>
															<td colspan="8">
																<textarea class="form-control" id="follow_up_result" name="data[follow_up_result]"><?php echo $auditData['follow_up_result'] ?></textarea>
															</td>
													 </tr>
													 <tr class="">
													 	<td colspan="4">Based on your follow up assessment, did the employee pass or fail?</td>
															<td colspan="2">
																<select class="form-control"  id="pass_fail_status" name="data[pass_fail_status]">
																	<option value=''>Select</option>
																<option <?php echo $auditData['pass_fail_status']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
																<option <?php echo $auditData['pass_fail_status']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
															</select>
															</td>
													 </tr>
													  <tr class=""  id='close_gap'>
													 	<td colspan="4">If failed, please also outline what are the next steps to close the gap?</td>
															<td colspan="8">
																<textarea class="form-control" name="data[close_gap]"><?php echo $auditData['close_gap'] ?></textarea>
															</td>
													 </tr>
													 <tr class="">
															<td colspan=3>Employee Signature :</td>
															<td colspan=3>
																<input type="text" readonly class="form-control" id="agent_id_ack_follow_up" name="" value="<?php echo $auditData['agent_name'] ?>" readonly>
															</td>
															<td colspan=3>Date:</td>
															<td colspan=3>
																<input type="text" class="form-control" id="" required value="<?php echo CurrDateMDY() ?>" readonly>
															</td>
													</tr>
													 <tr class="">
															<td colspan=3>Manager Signature:</td>
															<td colspan=3>
																<input type="text" class="form-control" id="tl_name_id_ack_follow_up"  value="<?php echo $auditData['tl_name'] ?>" readonly>
															</td>
															<td colspan=3>Date:</td>
															<td colspan=4>
																<input type="text" class="form-control" id="" required value="<?php echo $auditDate; ?>" readonly>
															</td>
													</tr>
											<?php

										}else{
											?>
											<tr class="follow_up_section" style="height:25px; font-weight:bold; display: none;">
										    <td colspan='12' style="text:center; background-color:black; color: white;">Follow-up Section</td>
										</tr>

										    <!-- Follow-up form fields go here -->
										    <tr class="follow_up_section" style="display: none;">
														<td colspan="2">Follow-up Actions - What are you listening for?:</td>
														<td colspan="2"><input type="text" class="form-control" id="follow_up_active_listening" name="data[follow_up_active_listening]" value="<?php echo $auditData['follow_up_active_listening'] ?>"></td>

														<td colspan="2">When - Date & Time:</td>
														<td colspan="2">
															<input type="text" class="form-control" id="call_date_time" name="call_date"  onkeydown="return false;" value="">
														</td>

														<td colspan="2">How:</td>
														<td colspan="2"><input type="text" class="form-control" id="follow_up_how" name="data[follow_up_how]" value="<?php echo $auditData['follow_up_how'] ?>"></td>
													</tr>

													<tr  class="follow_up_section" style="height:25px; font-weight:bold; display: none;">
														<td colspan='12' style="text:center; background-color:black; color: white;">Follow-up Results</td>
												 </tr>
												 <tr class="follow_up_section" style="display: none;">
												 	<td colspan="4">What was the outcome after the follow up inspection? Did we hear the desired behaviors based on the actions/commitments provided by agent in the last coaching session on the phone?</td>
														<td colspan="8">
															<textarea class="form-control" id="follow_up_result" name="data[follow_up_result]"><?php echo $auditData['follow_up_result'] ?></textarea>
														</td>
												 </tr>
												 <tr class="follow_up_section" style="display: none;">
												 	<td colspan="4">Based on your follow up assessment, did the employee pass or fail?</td>
														<td colspan="2">
															<select class="form-control"  id="pass_fail_status" name="data[pass_fail_status]">
																<option value=''>Select</option>
															<option <?php echo $auditData['pass_fail_status']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
															<option <?php echo $auditData['pass_fail_status']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
														</select>
														</td>
												 </tr>
												  <tr class="follow_up_section"  id='close_gap' style="display: none;">
												 	<td colspan="4">If failed, please also outline what are the next steps to close the gap?</td>
														<td colspan="8">
															<textarea class="form-control" name="data[close_gap]"><?php echo $auditData['close_gap'] ?></textarea>
														</td>
												 </tr>
												 <tr class="follow_up_section" style="display: none;">
														<td colspan=3>Employee Signature :</td>
														<td colspan=3>
															<input type="text" readonly class="form-control" id="agent_id_ack_follow_up" name="" value="" readonly>
														</td>
														<td colspan=3>Date:</td>
														<td colspan=3>
															<input type="text" class="form-control" id="" required value="<?php echo CurrDateMDY() ?>" readonly>
														</td>
												</tr>
												 <tr class="follow_up_section" style="display: none;">
														<td colspan=3>Manager Signature:</td>
														<td colspan=3>
															<input type="text" class="form-control" id="tl_name_id_ack_follow_up"  value="" readonly>
														</td>
														<td colspan=3>Date:</td>
														<td colspan=4>
															<input type="text" class="form-control" id="" required value="<?php echo $auditDate; ?>" readonly>
														</td>
												</tr>
										
											<tr>
											    <td colspan="8" style="text-align: right;">
											        <button class="btn btn-sm btn-success" type="button" id="add_follow_up" name="add_follow_up">
											            Add Follow Up
											        </button>
											    </td>
											</tr>
											<?php
										}
										?>
										


										<?php if ($att_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $auditData['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $auditData['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $auditData['mgnt_rvw_note'] ?></td>
											</tr>
											

											<tr>
												<td colspan=2 style="font-size:16px">Your Review</td>
												<td colspan=4><textarea class="form-control" style="width:100%" id="coaching_comment" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($att_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($auditData['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
													</tr>
										<?php
												}
											}
										}
										?>
										
								</tbody>
								<tfoot></tfoot>
							</table>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
						</div>
					</div>	
	</form>
				</div>
			</div>
		</div>

	</section>
</div>

<?php include ("qa_coaching_js_v1.php"); ?>

<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'coaching_comment' );
</script>
