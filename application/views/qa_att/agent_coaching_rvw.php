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
</style>

</style>


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
										<td colspan="6" id="theader" style="font-size:30px">Agent Coaching Form</td>
									</tr>
									<?php
										
											if($auditData['entry_by']!=''){
												$auditorName = $auditData['auditor_name'];
											}else{
												$auditorName = $auditData['client_name'];
											}
											$auditDate = mysql2mmddyy($auditData['audit_date']);
											$clDate_val = mdydt2mysql($auditData['call_date']);
											$sel='';
										
									?>
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Client:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<select class="form-control" style="text-align:center" id="client_id" name="client" disabled>
												<option value="">-Select-</option>
												<?php foreach ($client as $key => $value){ 
													if($value['id'] == $auditData['client_id']){
														$sel = 'selected';

													}else{
														$sel='';
													}
													?>
												<option value="<?php echo $value['id'] ?>" <?=$sel; ?>><?php echo $value['fullname'] ?></option>
											<?php } ?>
											</select>
										</td>
										<td>Process:</td>
										<td>
											<select class="form-control" style="text-align:center" id="process_client" name="process_client" readonly>
												<?php if($auditData['process_id']!=''){ ?>
												<option value="<?php echo $auditData['process_id']; ?>"><?php echo $auditData['process_name']; ?></option>
											<?php }?>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" style="text-align:center" id="agent_id" name="data[agent_id]" disabled>
												<?php if($auditData['agent_id']!=''){ ?>
												<option value="<?php echo $auditData['agent_id']; ?>"><?php echo $auditData['agent_name']."-(".$auditData['fusion_id'].")"; ?></option>
												<?php }?>
												<option value="">-Select-</option>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<?php if($auditData['assigned_to']!=''){ ?>
												<option value="<?php echo $auditData['assigned_to']; ?>"><?php echo $auditData['tl_name']; ?></option>
												<?php }?>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
											
										</td>
										<td>Call Date and Time:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" disabled autocomplete="off" onkeydown="return false;" value="<?php echo $auditData['call_date']; ?>"></td>
									</tr>
									<tr>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Site:</td>
										<td><input type="text" readonly class="form-control" id="site" name="data[site]" value="<?php echo $auditData['location']; ?>"></td>
										<td>Coaching Department:</td>
										<td><input type="text" readonly class="form-control" id="dept_id" name="dept_id" value="<?php echo $auditData['department_name']; ?>"></td>
									</tr>
									<tr>
										<td>Call ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_id" name="data[call_id]" value="<?php echo $auditData['call_id']; ?>" disabled></td>
										<td>Coaching Reason:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="coaching_reason" name="data[coaching_reason]"  disabled>
												<option value="">--Select--</option>
												<option value="Call Escalation"  <?= ($auditData['coaching_reason']=="Call Escalation")?"selected":"" ?>>Call Escalation</option>
												<option value="Call Management"  <?= ($auditData['coaching_reason']=="Call Management")?"selected":"" ?>>Call Management</option>
												<option value="Corrective Actions"  <?= ($auditData['coaching_reason']=="Corrective Actions")?"selected":"" ?>>Corrective Actions</option>
												<option value="Daily Specials"  <?= ($auditData['coaching_reason']=="Daily Specials")?"selected":"" ?>>Daily Specials</option>
												<option value="Discovery Session"  <?= ($auditData['coaching_reason']=="Discovery Session")?"selected":"" ?>>Discovery Session</option>
												<option value="Employee Recognition"  <?= ($auditData['coaching_reason']=="Employee Recognition")?"selected":"" ?>>Employee Recognition</option>
												<option value="Follow up"  <?= ($auditData['coaching_reason']=="Follow up")?"selected":"" ?>>Follow up</option>
												<option value="General"  <?= ($auditData['coaching_reason']=="General")?"selected":"" ?>>General</option>
												<option value="Goals and Progress"  <?= ($auditData['coaching_reason']=="Goals and Progress")?"selected":"" ?>>Goals and Progress</option>
												<option value="Group Session"  <?= ($auditData['coaching_reason']=="Group Session")?"selected":"" ?>>Group Session</option>
												<option value="Performance Review"  <?= ($auditData['coaching_reason']=="Performance Review")?"selected":"" ?>>Performance Review</option>
												<option value="Personal Challenges"  <?= ($auditData['coaching_reason']=="Personal Challenges")?"selected":"" ?>>Personal Challenges</option>
												<option value="Product Knowledge"  <?= ($auditData['coaching_reason']=="Product Knowledge")?"selected":"" ?>>Product Knowledge</option>
												<option value="Productivity"  <?= ($auditData['coaching_reason']=="Productivity")?"selected":"" ?>>Productivity</option>
												<option value="Quality Assurance"  <?= ($auditData['coaching_reason']=="Quality Assurance")?"selected":"" ?>>Quality Assurance</option>
												<option value="Retention"  <?= ($auditData['coaching_reason']=="Retention")?"selected":"" ?>>Retention</option>
												<option value="Schedule Adherence"  <?= ($auditData['coaching_reason']=="Schedule Adherence")?"selected":"" ?>>Schedule Adherence</option>
												<option value="Survey Follow up"  <?= ($auditData['coaching_reason']=="Survey Follow up")?"selected":"" ?>>Survey Follow up</option>
												<option value="QA Audit Review"  <?= ($auditData['coaching_reason']=="QA Audit Review")?"selected":"" ?>>QA Audit Review</option>
												<option value="TL Audit Review"  <?= ($auditData['coaching_reason']=="TL Audit Review")?"selected":"" ?>>TL Audit Review</option>
												<option value="Trainer Audit Review"  <?= ($auditData['coaching_reason']=="Trainer Audit Review")?"selected":"" ?>>Trainer Audit Review</option>
												<option value="ZTP"  <?= ($auditData['coaching_reason']=="ZTP")?"selected":"" ?>>ZTP</option>
												<option value="Critical Error"  <?= ($auditData['coaching_reason']=="Critical Error")?"selected":"" ?>>Critical Error</option>
											</select>
										</td>
										<td>Call Type:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[call_type]" value="<?php echo $auditData['call_type']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Observation Method:</td>
										<td>
											<select class="form-control" name="data[observation_method]">
												<option value="">--Select--</option>
												<option value="Displayed"  <?= ($auditData['observation_method']=="Displayed")?"selected":"" ?>>Displayed</option>
												<option value="Remote"  <?= ($auditData['observation_method']=="Remote")?"selected":"" ?>>Remote</option>
												<option value="SBS"  <?= ($auditData['observation_method']=="SBS")?"selected":"" ?>>SBS</option>
												<option value="Call Recording"  <?= ($auditData['observation_method']=="Call Recording")?"selected":"" ?>>Call Recording</option>
											</select>
										</td>
										<td>For Follow Up?:</td>
										<td>
											<select class="form-control" name="data[for_follow_up]">
												<option value="">--Select--</option>
												<option value="Displayed"  <?= ($auditData['for_follow_up']=="Displayed")?"selected":"" ?>>Displayed</option>
												<option value="Yes"  <?= ($auditData['for_follow_up']=="Yes")?"selected":"" ?>>Yes</option>
												<option value="No"  <?= ($auditData['for_follow_up']=="No")?"selected":"" ?>>No</option>
											</select>
										</td>
										<td>Coaching Documentation:</td>
										<td><textarea class="form-control" name="data[coaching_docu]"><?php echo $auditData['coaching_docu'] ?></textarea></td>
									</tr>
									<tr class="rca_fields" style="display:none">
										<td colspan="6">Root Cause Analysis</td>
									</tr>
									<tr class="rca_fields" style="display:none">
										<td colspan="2">
											<label for="rca_level1">Level 1</label>
											<select id="rca_level1" name="rca_level1" class="form-control">
												<option value="">-- SELECT --</option>
												<option value="system">System</option>
												<option value="ability">Ability</option>
												<option value="will">Will</option>
												<option value="health">Health</option>
												<option value="cap_issue">Capacity Issue</option>
												<option value="environment">Environment</option>
											</select>
										</td>
										<td colspan="2">
											<label for="rca_level2">Level 2</label>
											<select id="rca_level2" name="rca_level2" class="form-control">
											</select>
										</td>
										<td colspan="2">
											<label for="rca_level3">Level 3</label>
											<select id="rca_level3" name="rca_level3" class="form-control">
											</select>
										</td>
									</tr>
									<div class="common-space">
			<div class="row">
				<div class="col-sm-12">
					<div class="card mb-4">
						<div class="card-body">
							<table class="table table-striped ">
								<thead>
									<th></th>
									<th>QA Parameter</th>
									<th>Rating</th>
									<th>Remarks</th>
								</thead>
								<tbody>
									<tr>
										<th scope="row" class="scope" rowspan=17>STANDARD/ disabled QUALITY</th>
										<td class="paddingTop">Greeting</td>
										<td>
											<select class="form-control scorecalc" name="data[greeting]" disabled>
												<option value="">Select</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['greeting']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['greeting']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['greeting']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt1]"><?php echo $auditData['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Make it Personal</td>
										<td>
											<select class="form-control scorecalc" name="data[make_it_personal]" disabled>
												<option value="">Select</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['make_it_personal']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['make_it_personal']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['make_it_personal']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt2]"><?php echo $auditData['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Acknowledge</td>
										<td>
											<select class="form-control scorecalc" name="data[acknowledge]" disabled>
												<option value="">Select</option>
												<option scr_val='6' scr_max='6' <?php echo $auditData['acknowledge']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='6' <?php echo $auditData['acknowledge']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='6' scr_max='6' <?php echo $auditData['acknowledge']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt3]"><?php echo $auditData['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Empathy</td>
										<td>
											<select class="form-control scorecalc" name="data[empathy]" disabled>
												<option value="">Select</option>
												<option scr_val='6' scr_max='6' <?php echo $auditData['empathy']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='6' <?php echo $auditData['empathy']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='6' scr_max='6' <?php echo $auditData['empathy']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt4]"><?php echo $auditData['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Reassurance</td>
										<td>
											<select class="form-control scorecalc" name="data[reassurance]" disabled>
												<option value="">Select</option>
												<option scr_val='6' scr_max='6' <?php echo $auditData['reassurance']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='6' <?php echo $auditData['reassurance']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='6' scr_max='6' <?php echo $auditData['reassurance']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt5]"><?php echo $auditData['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">CPNI</td>
										<td>
											<select class="form-control scorecalc" name="data[cpni]" disabled>
												<option value="">Select</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['cpni']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['cpni']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['cpni']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt6]"><?php echo $auditData['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Positive Scripting/Positive Positioning</td>
										<td>
											<select class="form-control scorecalc" name="data[positive_scripting]" disabled>
												<option value="">Select</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['positive_scripting']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['positive_scripting']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['positive_scripting']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt7]"><?php echo $auditData['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Hold & Dead Air</td>
										<td>
											<select class="form-control scorecalc" name="data[hold_dead_air]" disabled>
												<option value="">Select</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['hold_dead_air']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['hold_dead_air']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['hold_dead_air']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt8]"><?php echo $auditData['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Transfer Procedures</td>
										<td>
											<select class="form-control scorecalc" name="data[transfer_procedure]" disabled>
												<option value="">Select</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['transfer_procedure']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['transfer_procedure']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['transfer_procedure']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt9]"><?php echo $auditData['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Escalation Prevention</td>
										<td>
											<select class="form-control scorecalc" name="data[escalation_prevention]" disabled>
												<option value="">Select</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['escalation_prevention']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['escalation_prevention']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['escalation_prevention']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt10]"><?php echo $auditData['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Ownership</td>
										<td>
											<select class="form-control scorecalc" name="data[ownership]" disabled>
												<option value="">Select</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['ownership']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['ownership']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['ownership']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt11]"><?php echo $auditData['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Resolution Steps</td>
										<td>
											<select class="form-control scorecalc" name="data[resolution_steps]" disabled>
												<option value="">Select</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['resolution_steps']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['resolution_steps']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['resolution_steps']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt12]"><?php echo $auditData['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Resource Utilization</td>
										<td>
											<select class="form-control scorecalc" name="data[resource_utilization]" disabled>
												<option value="">Select</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['resource_utilization']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['resource_utilization']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['resource_utilization']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt13]"><?php echo $auditData['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Fully Resolve</td>
										<td>
											<select class="form-control scorecalc" name="data[fully_resolve]" disabled>
												<option value="">Select</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['fully_resolve']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='7' <?php echo $auditData['fully_resolve']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='7' scr_max='7' <?php echo $auditData['fully_resolve']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt14]"><?php echo $auditData['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Recap</td>
										<td>
											<select class="form-control scorecalc" name="data[recap]" disabled>
												<option value="">Select</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['recap']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['recap']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['recap']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt15]"><?php echo $auditData['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Additional Assistance</td>
										<td>
											<select class="form-control scorecalc" name="data[aditional_assistance]" disabled>
												<option value="">Select</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['aditional_assistance']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['aditional_assistance']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['aditional_assistance']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt16]"><?php echo $auditData['cmt16'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Proper Closing</td>
										<td>
											<select class="form-control scorecalc" name="data[proper_closing]" disabled>
												<option value="">Select</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['proper_closing']=="Effective"?"selected":"";?> value="Effective">Effective</option>
												<option scr_val='0' scr_max='5' <?php echo $auditData['proper_closing']=="Not Effective"?"selected":"";?> value="Not Effective">Not Effective</option>
												<option scr_val='5' scr_max='5' <?php echo $auditData['proper_closing']=="N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt17]"><?php echo $auditData['cmt17'] ?></textarea></td>
									</tr>
								
									<tr>
										<th scope="row" class="scope" rowspan=21>STANDARD/ disabled COMPLIANCE</th>
										<td class="paddingTop">Authentication</td>
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[authentication]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['authentication']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['authentication']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt18]"><?php echo $auditData['cmt18'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Call Recording Disclaimer</td>
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[call_recording_disclamer]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['call_recording_disclamer']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['call_recording_disclamer']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt19]"><?php echo $auditData['cmt19'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">CPNI</td>
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[compliance_cpni]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['compliance_cpni']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['compliance_cpni']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt20]"><?php echo $auditData['cmt20'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Was the agent seen retaining, collecting, accessing, and/or using CX information</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[agent_seen_retaining]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['agent_seen_retaining']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['agent_seen_retaining']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt21]"><?php echo $auditData['cmt21'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">disabled disclosures</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[disabled_disclosures]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['disabled_disclosures']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['disabled_disclosures']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt22]"><?php echo $auditData['cmt22'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">CBR Disclaimer</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[cbr_disclaimer]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['cbr_disclaimer']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['cbr_disclaimer']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt23]"><?php echo $auditData['cmt23'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Hold >4 minutes</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[hold_4_min]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['hold_4_min']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['hold_4_min']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt24]"><?php echo $auditData['cmt24'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Documentation</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[documentation]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['documentation']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['documentation']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt25]"><?php echo $auditData['cmt25'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Added to CX account without permission</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[added_cx_acount]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['added_cx_acount']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['added_cx_acount']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt26]"><?php echo $auditData['cmt26'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Vulgar, Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[offensive_language]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['offensive_language']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['offensive_language']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt27]"><?php echo $auditData['cmt27'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Derogatory references</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[derogatory_reference]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['derogatory_reference']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['derogatory_reference']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt28]"><?php echo $auditData['cmt28'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Rude, abusive,  or discourteous</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[rude_abusive]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['rude_abusive']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['rude_abusive']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt29]"><?php echo $auditData['cmt29'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Flirting or making social engagements</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[making_social_engagement]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['making_social_engagement']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['making_social_engagement']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt30]"><?php echo $auditData['cmt30'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Hung up</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[hung_up]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['hung_up']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['hung_up']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt31]"><?php echo $auditData['cmt31'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Blind transferred</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[blind_transfer]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['blind_transfer']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['blind_transfer']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt32]"><?php echo $auditData['cmt32'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Intentionally transfer/reassign/redirect the call</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[intentionally_transfer]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['intentionally_transfer']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['intentionally_transfer']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt33]"><?php echo $auditData['cmt33'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Intentional disseminating of inaccurate information or troubleshooting steps to release the call</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[intentionally_disseminating]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['intentionally_disseminating']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['intentionally_disseminating']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt34]"><?php echo $auditData['cmt34'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">intentionally ignoring cx from the queue</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[intentionally_ignoring]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['intentionally_ignoring']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['intentionally_ignoring']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt35]"><?php echo $auditData['cmt35'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Camping</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[camping]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['camping']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['camping']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt36]"><?php echo $auditData['cmt36'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Falsify AT&T’s or Cx records</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[falsify_att]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['falsify_att']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['falsify_att']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt37]"><?php echo $auditData['cmt37'] ?></textarea></td>
									</tr>
									<tr>
										<td class="paddingTop">Misrepresent or misleading</td>
										
										<td>
											<select class="form-control comp_scorecalc" id="" name="data[misrepresent]" disabled>
												<option value="">Select</option>
												<option <?php echo $auditData['misrepresent']=="No"?"selected":"";?> value="No">No</option>
												<option <?php echo $auditData['misrepresent']=="Yes"?"selected":"";?> value="Yes">Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt38]"><?php echo $auditData['cmt38'] ?></textarea></td>
									</tr>
									<tr>
											<td>Comments:</td>
											<td colspan=4><textarea class="form-control" disabled name="data[call_summary]"><?php echo $auditData['call_summary'] ?></textarea></td>
										</tr>

										<?php if($auditData['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$auditData['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_att/gbrm/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_att/gbrm/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $auditData['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $auditData['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="8" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=4>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $auditData['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $auditData['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $auditData['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($auditData['entry_date'],72) == true){ ?>
											<tr>
												<?php if($auditData['agent_rvw_note']==''){ ?>
													<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
										
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

<?php include ("qa_coaching_js.php"); ?>

<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'coaching_comment' );
</script>
