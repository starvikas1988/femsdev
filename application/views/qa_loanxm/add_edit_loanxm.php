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
	background-color:#85C1E9;
}

</style>

<?php if($loanxm_id!=0){
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
							<table class="table  skt-table" width="100%">
								<tbody>
									<tr>
										<td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #16A5CB ;">Debt Solution 123</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($loanxm_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($loanxm['entry_by']!=''){
												$auditorName = $loanxm['auditor_name'];
											}else{
												$auditorName = $loanxm['client_name'];
											}
											$auditDate = mysql2mmddyy($loanxm['audit_date']);
											$clDate_val = mysql2mmddyy($loanxm['call_date']);
										}
									?>
									<tr>
										<td style="width:16%">Auditor Name:</td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:16%">Audit Date:</td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:16%">Call Date:</td>
										<td style="width:16%"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $loanxm['agent_id'] ?>"><?php echo $loanxm['fname']." ".$loanxm['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
											<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $loanxm['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $loanxm['tl_id'] ?>"><?php echo $loanxm['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['name']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $loanxm['call_duration'] ?>" required ></td>
										<td>Type of Call:</td>
										<td>
											<select class="form-control" name="data[call_type]" required>
												<option value="<?php echo $loanxm['call_type'] ?>"><?php echo $loanxm['call_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Inbound">Inbound</option>
												<option value="Outbound">Outbound</option>
											</select>
										</td>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" name="data[five9_id]" value="<?php echo $loanxm['five9_id'] ?>" required ></td>
									</tr>
									<tr>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" name="data[customer_name]" value="<?php echo $loanxm['customer_name'] ?>" required ></td>
										<td>Customer Contact number:</td>
										<td><input type="text" class="form-control" name="data[customer_contact]" value="<?php echo $loanxm['customer_contact'] ?>" required ></td>
										<td>Disposition</td>
										<td><input type="text" class="form-control" name="data[disposition]" value="<?php echo $loanxm['disposition'] ?>"required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $loanxm['audit_type'] ?>"><?php echo $loanxm['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
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
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $loanxm['voc'] ?>"><?php echo $loanxm['voc'] ?></option>
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
										<td style="font-weight:bold; font-size:16px;">Pass/Fail</td>
										<td><input type="text" readonly id="loanxm_passfail" name="data[pass_fail]" class="form-control" value="<?php echo $loanxm['pass_fail'] ?>"></td>
									</tr>
									<tr>
										
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" value="<?= $loanxm['earned_score']?>" readonly id="loanxm_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" value="<?= $loanxm['possible_score']?>" readonly id="loanxm_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="loanxmOverallScore" name="data[overall_score]" class="form-control loanxmFatal_ds" style="font-weight:bold" value="<?php if($loanxm['overall_score']){ echo $loanxm['overall_score'].'%'; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									
									<tr style=" font-weight:bold;background-color: #D3E32D ;">
										<td>#</td><td colspan="2">Question</td><td>Points</td><td>Criticalities</td><td>Score</td>
									</tr>
									<tr><td colspan=6 style="background-color:skyblue; text-align:left;">SECTION 1 - Adherence to Script</td></tr>
									<tr>
										<td>a</td>
										<td colspan=2>Opening/Introduction (Almost identical for inbound vs outbound)</td>
										<td>8</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[opening_introduction]" required>
												<option value="">-Select-</option>
												<option loanxm_val=8 <?php echo $loanxm['opening_introduction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=8 <?php echo $loanxm['opening_introduction'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['opening_introduction'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>b</td>
										<td colspan=2>Qualifying Questions</td>
										<td>6</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[qualifying_questions]" required>
												<option value="">-Select-</option>
												<option loanxm_val=6 <?php echo $loanxm['qualifying_questions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=6 <?php echo $loanxm['qualifying_questions'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['qualifying_questions'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>c</td>
										<td colspan=2 >Conclusion - varies for a LT vs Post vs Call Backs</td>
										<td >6</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[conclusion]" required>
												<option value="">-Select-</option>
												<option loanxm_val=6 <?php echo $loanxm['conclusion'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=6 <?php echo $loanxm['conclusion'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['conclusion'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>  
										</td>
									</tr>
									<tr>
										<td>d</td>
										<td colspan=2>Questions and Rebuttals</td>
										<td>6</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[questions_rebuttals]" required>
												<option value="">-Select-</option>
												<option loanxm_val=6 <?php echo $loanxm['questions_rebuttals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=6 <?php echo $loanxm['questions_rebuttals'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['questions_rebuttals'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr><td colspan=6 style="background-color:skyblue; text-align: left;">SECTION 2 - Communication Skills</td></tr>
									<tr>
										<td>a</td>
										<td colspan=2>Uses appropriate tone, pace, and voice inflection.</td>
										<td>8</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[voice_quality]" required>
												<option value="">-Select-</option>
												<option loanxm_val=8 <?php echo $loanxm['voice_quality'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=8 <?php echo $loanxm['voice_quality'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['voice_quality'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>b</td>
										<td colspan=2>Did the agent use proper word choice, pronunciation, and enunciation?.</td>
										<td>8</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[pronunciation]" required>
												<option value="">-Select-</option>
												<option loanxm_val=8 <?php echo $loanxm['pronunciation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=8 <?php echo $loanxm['pronunciation'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['pronunciation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>c</td>
										<td colspan=2>Listen actively and respond appropriately without interrupting customer?</td>
										<td>10</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[listen_actively]" required>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php echo $loanxm['listen_actively'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php echo $loanxm['listen_actively'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['listen_actively'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr><td colspan=6 style="background-color:skyblue; text-align: left;">SECTION 3 - Technical and Procedural</td></tr>
									<!-- <tr>
										<td>a</td>
										<td colspan=2>Used manual connector to pull up lead in Portal</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[lead_portal]" required>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php //echo $loanxm['lead_portal'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php //echo $loanxm['lead_portal'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php //echo $loanxm['lead_portal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr> -->
									<tr>
										<td>a</td>
										<td colspan=2>Properly Identified client is the person on the call.</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[identified]" required>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php echo $loanxm['identified'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php echo $loanxm['identified'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['identified'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>b</td>
										<td colspan=2>All Portal Fields filled out correctly</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[all_portal_fields]" required>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php echo $loanxm['all_portal_fields'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php echo $loanxm['all_portal_fields'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['all_portal_fields'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<!-- <tr>
										<td>c</td>
										<td colspan=2>Dispostioned properly in Portal (Green Light, Yellow light with time of day, Dispo for Red Light)</td>
										<td>10</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[disposition_in_portal]" required>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php //echo $loanxm['disposition_in_portal'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php //echo $loanxm['disposition_in_portal'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php //echo $loanxm['disposition_in_portal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>-->
									<tr>
										<td>c</td>
										<td colspan=2>Process lead properly with the portal.</td>
										<td>10</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[process_lead]" required>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php echo $loanxm['process_lead'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php echo $loanxm['process_lead'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['process_lead'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>Process lead properly with the portal. 
									<tr>
										<td>d</td>
										<td colspan=2>If Red Light - Did agent proceed to Credit Card page in Portal?</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[red_creditcard_portal]" required>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php echo $loanxm['red_creditcard_portal'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php echo $loanxm['red_creditcard_portal'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['red_creditcard_portal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<!-- <tr>
										<td>e</td>
										<td colspan=2>Dispositioned properly in Five9</td>
										<td>10</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[dispositioned_five9]" required>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php //echo $loanxm['dispositioned_five9'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php //echo $loanxm['dispositioned_five9'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php //echo $loanxm['dispositioned_five9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr> -->
									<tr>
										<td>e</td>
										<td colspan=2>Term Coded properly in Livebox and Dispositioned correctly in TMI</td>
										<td>10</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[dispositioned_livebox]" required>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php echo $loanxm['dispositioned_livebox'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php echo $loanxm['dispositioned_livebox'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['dispositioned_livebox'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									
									<tr>
										<td>f</td>
										<td colspan=2>Proper phone system procedure to complete Live Transfer</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[live_transfer_phone]" required>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php echo $loanxm['live_transfer_phone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php echo $loanxm['live_transfer_phone'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['live_transfer_phone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr><td colspan=6 style="background-color:skyblue; text-align: left;">SECTION 4 - Misc</td></tr>
									<tr>
										<td>a</td>
										<td colspan=2>Did the agent use the prospects name at least twice?</td>
										<td>4</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[agent_use_prospect_name]" required>
												<option value="">-Select-</option>
												<option loanxm_val=4 <?php echo $loanxm['agent_use_prospect_name'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=4 <?php echo $loanxm['agent_use_prospect_name'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['agent_use_prospect_name'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>b</td>
										<td colspan=2>Did the agent reference to our Texas Office when applicable?</td>
										<td>4</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[agent_houston_office]" required>
												<option value="">-Select-</option>
												<option loanxm_val=4 <?php echo $loanxm['agent_houston_office'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=4 <?php echo $loanxm['agent_houston_office'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['agent_houston_office'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>

									<tr>
										<td>c</td>
										<td colspan=2>Background sound quality</td>
										<td>0</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point" name="data[quality]" required>
												<option value="">-Select-</option>
												<option loanxm_val=0 <?php echo $loanxm['quality'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['quality'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option loanxm_val=0 <?php echo $loanxm['quality'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
											</select> 
										</td>
									</tr>
									
									<tr><td colspan=6 style="background-color:skyblue; text-align: left;">SECTION 5-  INBOUND EXISTING CUSTOMER</td></tr>
									<tr>
										<td>a</td>
										<td colspan=2>Proper script was used. It was made abundantly clear Debt Solutions 123 is a strategic partner of SOD and CSF?</td>
										<td>20</td>
										<td class="eml">Compliance</td>
										<td>
											<select class="form-control loanxm_point compliance section5" id="idfc_new_AF1" name="data[proper_script_use]" required>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm['proper_script_use'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php echo $loanxm['proper_script_use'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['proper_script_use'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<!-- <tr>
										<td>b</td>
										<td colspan=2>Call Acknowledgement</td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business section5" id="idfc_new_AF2" name="data[call_acknowledge]" required>
												<option value="">-Select-</option>
												<option loanxm_val=0 <?php //echo $loanxm['call_acknowledge'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php //echo $loanxm['call_acknowledge'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php //echo $loanxm['call_acknowledge'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
									</tr> -->
									<tr>
										<td>b</td>
										<td colspan=2>Timely Response</td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business section5" id="idfc_new_AF2" name="data[timely_response]" required>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm['timely_response'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php echo $loanxm['timely_response'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['timely_response'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
								
									<tr>
										<td>c</td>
										<td colspan=2>Failure to Disposition TMI</td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business section5" id="idfc_new_AF2" name="data[TMI]" required>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm['TMI'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php echo $loanxm['TMI'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['TMI'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>

									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned"></td><td>Earned:</td><td id="busiJiCisEarned"></td><td>Earned:</td><td id="complJiCisEarned"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible"></td><td>Possible:</td><td id="busiJiCisPossible"></td><td>Possible:</td><td id="complJiCisPossible"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="data[customer_score]" value="<?php echo $loanxm['customer_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="data[business_score]" value="<?php echo $loanxm['business_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="data[compliance_score]" value="<?php echo $loanxm['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $loanxm['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $loanxm['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($loanxm_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($loanxm['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$loanxm['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_loanxm/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_loanxm/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($loanxm_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $loanxm['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $loanxm['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $loanxm['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $loanxm['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($loanxm_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($loanxm['entry_date'],72) == true){ ?>
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
