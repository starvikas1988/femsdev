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
	background-color:#AED6F1;
}
</style>

<?php if($sas_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">Specialty Answering Service</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($sas_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($sas['entry_by']!=''){
												$auditorName = $sas['auditor_name'];
											}else{
												$auditorName = $sas['client_name'];
											}
											$auditDate = mysql2mmddyy($sas['audit_date']);
											$clDate_val = mysql2mmddyy($sas['call_date']);
										}
									?>
									<tr>
										<td style="width:150px">Auditor Name:</td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td style="width:150px"><input type="text" class="form-control" onkeydown="return false;" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												
												<?php if($sas['agent_id']){?><option value="<?php echo $sas['agent_id'] ?>"><?php echo $sas['fname']." ".$sas['lname'] ?></option><?php } ?>
												<option value="">Select</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" value="<?php echo $sas['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $sas['tl_id'] ?>"><?php echo $sas['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Process:</td>
										<td><input type="text" class="form-control" id="campaign" value="<?php echo $sas['process'] ?>" readonly ></td>
									</tr>
									<tr>
										<td>Site/Location:</td>
										<td><input type="text" readonly class="form-control" id="office_id" value="<?php echo $sas['office_id'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $sas['call_duration']; ?>" required ></td>
										<td>File No:</td>
										<td><input type="text" class="form-control" id="" name="data[file_no]" value="<?php echo $sas['file_no']; ?>" required ></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required >
												<option value="">-Select-</option>
												<option <?php echo $sas['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $sas['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $sas['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $sas['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $sas['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
												<?php if(get_login_type()!="client"){ ?>
													<option <?php echo $sas['audit_type']=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
													<option <?php echo $sas['audit_type']=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
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
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required >
												<option value="">-Select-</option>
												<option <?php echo $sas['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $sas['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $sas['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $sas['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $sas['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Earned Score</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $sas['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Possible Score</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $sas['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Overall Score:</td>
										<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control sasFatal" style="font-weight:bold" value="<?php echo $sas['overall_score'] ?>"></td>
									</tr>
									<tr>
										<td class="eml">Parameter</td>
										<td class="eml">Sub Parameter</td>
										<td class="eml">Status</td>
										<td class="eml">Score</td>
										<td class="eml">Comments/Notes</td>
										<td class="eml">Critical Accuracy</td>
										
									</tr>
									<tr>
									<td class="eml" rowspan="2">Greeting</td>
																	
										<td style="text-align:left;" >1.1 Did the rep greet the customer promptly? </td>
										<td>
											<select class="form-control ameridial customer" name="data[greet_customer_properly]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['greet_customer_properly']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['greet_customer_properly']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['greet_customer_properly']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $sas['cmt1']; ?>"></td>
										<td class="" style="background-color:#A9DFBF" >Customer Critical</td>
									</tr>
									<tr>
									
										<td style="text-align:left;" >1.2 Did the rep use the proper scripting for the Greeting?</td>
										<td>
											<select class="form-control ameridial business" name="data[use_respectful_tone]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['use_respectful_tone']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['use_respectful_tone']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['use_respectful_tone']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $sas['cmt2']; ?>"></td>
										<td class="" style="background-color:#FADBD8">Business Critical</td>
									</tr>
									<tr>
									<td class="eml" rowspan="4">Zero Tolerance Violations ***(auto-fails)***</td>
										<td style="text-align:left; color:red" >2.1 Did the agent use any inappropriate language? (Rude Remarks)</td>
										<td>
											<select class="form-control ameridial customer" id="sasAF1" name="data[use_inappropiate_language]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['use_inappropiate_language']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['use_inappropiate_language']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<!-- <option amd_val=0 <?php echo $sas['use_inappropiate_language']=='N/A'?"selected":""; ?> value="N/A">N/A</option> -->
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $sas['cmt3']; ?>"></td>
										<td class="" style="background-color:#A9DFBF">Customer Critical</td>	
									</tr>
									<tr>
										<td style="text-align:left; color:red" >2.2 Did the agent end the call before completing each required step?</td>
										<td>
											<select class="form-control ameridial business" id="sasAF2" name="data[end_call_before_complete]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['end_call_before_complete']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['end_call_before_complete']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<!-- <option amd_val=0 <?php echo $sas['end_call_before_complete']=='N/A'?"selected":""; ?> value="N/A">N/A</option> -->
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $sas['cmt4']; ?>"></td>
										<td class="" style="background-color:#FADBD8">Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left; color:red" >2.3 Did the agent attempt to give any medical advice?</td>
										<td>
											<select class="form-control ameridial business" id="sasAF3" name="data[give_medical_advise]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['give_medical_advise']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['give_medical_advise']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<!-- <option amd_val=0 <?php echo $sas['give_medical_advise']=='N/A'?"selected":""; ?> value="N/A">N/A</option> -->
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $sas['cmt5']; ?>"></td>
										<td class="" style="background-color:#FADBD8">Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left; color:red" >2.4 Did the agent fail to use mute or hold properly? (There should be no background noise)</td>
										<td>
											<select class="form-control ameridial business" id="sasAF4" name="data[did_the_agent_fail]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['did_the_agent_fail']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['did_the_agent_fail']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<!-- <option amd_val=0 <?php echo $sas['did_the_agent_fail']=='N/A'?"selected":""; ?> value="N/A">N/A</option> -->
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $sas['cmt6']; ?>"></td>
										<td class="" style="background-color:#FADBD8">Business Critical</td>
									</tr>
									
									<tr>
									<td class="eml" rowspan="8">Call Flow & Soft Skills</td>
										<td style="text-align:left;" >3.1 Did the agent have a pleasant tone?</td>
										<td>
											<select class="form-control ameridial customer" name="data[agent_have_pleasant_tone]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_have_pleasant_tone']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['agent_have_pleasant_tone']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_have_pleasant_tone']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $sas['cmt7']; ?>"></td>
										<td class="" style="background-color:#A9DFBF">Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >3.2 Did the agent follow all processes and procedures?</td>
										<td>
											<select class="form-control ameridial business" name="data[agent_follow_all_procedure]" required>
												<option value="">-Select-</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['agent_follow_all_procedure']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=7 <?php echo $sas['agent_follow_all_procedure']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['agent_follow_all_procedure']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>7%</td>
										<td ><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $sas['cmt8']; ?>"></td>
										<td class="" style="background-color:#FADBD8">Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >3.3 Did the agent use please and thank you throughout the call?</td>
										<td>
											<select class="form-control ameridial customer" name="data[agent_use_please_thank]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_use_please_thank']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['agent_use_please_thank']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_use_please_thank']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $sas['cmt9']; ?>"></td>
										<td class="" style="background-color:#A9DFBF">Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >3.4 Did the agent schedule the appointment correctly if necessary?</td>
										<td>
											<select class="form-control ameridial business" name="data[agent_schedule_appointment]" required>
												<option value="">-Select-</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['agent_schedule_appointment']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=7 <?php echo $sas['agent_schedule_appointment']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['agent_schedule_appointment']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>7%</td>
										<td ><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $sas['cmt10']; ?>"></td>
										<td class="" style="background-color:#FADBD8">Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >3.5 Did the agent minimize extended silences throughout the call?</td>
										<td>
											<select class="form-control ameridial customer" name="data[agent_minimise_extended_silence]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_minimise_extended_silence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['agent_minimise_extended_silence']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_minimise_extended_silence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $sas['cmt11']; ?>"></td>
										<td class="" style="background-color:#A9DFBF">Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >3.6 Did the agent answer any and all questions the caller had effectively?</td>
										<td>
											<select class="form-control ameridial business" name="data[agent_answer_all_question]" required>
												<option value="">-Select-</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['agent_answer_all_question']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=7 <?php echo $sas['agent_answer_all_question']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['agent_answer_all_question']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>7%</td>
										<td ><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $sas['cmt12']; ?>"></td>
										<td class="" style="background-color:#FADBD8">Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >3.7 Did the agent verify the caller's information? (name, ph #, address, email, etc.)</td>
										<td>
											<select class="form-control ameridial compliance1" name="data[did_the_agent_verify_the_caller]" required>
												<option value="">-Select-</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['did_the_agent_verify_the_caller']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=7 <?php echo $sas['did_the_agent_verify_the_caller']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['did_the_agent_verify_the_caller']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>7%</td>
										<td ><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $sas['cmt13']; ?>"></td>
										<td class="" style="background-color:#F9E79F">Compliance Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >3.8 Did the agent use the caller's name at least once during the call? </td>
										<td>
											<select class="form-control ameridial customer" name="data[agent_use_the_caller]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_use_the_caller']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['agent_use_the_caller']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_use_the_caller']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $sas['cmt14']; ?>"></td>
										<td class="" style="background-color:#A9DFBF">Customer Critical</td>
									</tr>
								
									<tr>
									<td class="eml" rowspan="4">Closing</td>
										<td style="text-align:left;" >4.1 Did the agent close correctly by thanking the caller?</td>
										<td>
											<select class="form-control ameridial customer" name="data[agent_correct_thinking_caller]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_correct_thinking_caller']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['agent_correct_thinking_caller']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_correct_thinking_caller']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $sas['cmt15']; ?>"></td>
										<td class="" style="background-color:#A9DFBF">Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >4.2 Did the agent document appropriately?</td>
										<td>
											<select class="form-control ameridial business" name="data[agent_document_appropiately]" required>
												<option value="">-Select-</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['agent_document_appropiately']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=7 <?php echo $sas['agent_document_appropiately']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=7 amd_max=7 <?php echo $sas['agent_document_appropiately']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>7%</td>
										<td ><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $sas['cmt16']; ?>"></td>
										<td class="" style="background-color:#FADBD8">Business Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >4.3 Did the agent correctly transfer the call (if necessary)?</td>
										<td>
											<select class="form-control ameridial customer" name="data[agent_correct_call_transfer]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_correct_call_transfer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['agent_correct_call_transfer']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_correct_call_transfer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $sas['cmt17']; ?>"></td>
										<td class="" style="background-color:#A9DFBF">Customer Critical</td>
									</tr>
									<tr>
										<td style="text-align:left;" >4.4 Did the agent correctly dispose the call?</td>
										<td>
											<select class="form-control ameridial business" name="data[agent_correct_dispose_call]" required>
												<option value="">-Select-</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_correct_dispose_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=0 amd_max=5 <?php echo $sas['agent_correct_dispose_call']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 amd_max=5 <?php echo $sas['agent_correct_dispose_call']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5%</td>
										<td ><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $sas['cmt18']; ?>"></td>
										<td class="" style="background-color:#A9DFBF">Business Critical</td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="custEarn" name="data[customerscore]" value="<?php echo $sas['customerscore'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="bussEarn" name="data[businessscore]" value="<?php echo $sas['businessscore'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="compEarn" name="data[compliancescore]" value="<?php echo $sas['compliancescore'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="custPossible" name="data[customerscoreable]" value="<?php echo $sas['customerscoreable'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="bussPossible" name="data[businessscoreable]" value="<?php echo $sas['businessscoreable'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="compPossible" name="data[compliancescoreable]" value="<?php echo $sas['compliancescoreable'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="custScore" name="data[customer_score_percent]" value="<?php echo $sas['customer_score_percent'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="bussScore" name="data[business_score_percent]" value="<?php echo $sas['business_score_percent'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="compScore" name="data[compliance_score_percent]" value="<?php echo $sas['compliance_score_percent'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $sas['call_summary']; ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $sas['feedback']; ?></textarea></td>
									</tr>
									
									<?php if($sas_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files (WAV,WMV,MP3,MP4)</td>
										<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files</td>
										<?php if($sas['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$sas['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/sas/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/sas/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($sas_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $sas['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $sas['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $sas['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $sas['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($sas_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($sas['entry_date'],72) == true){ ?>
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


<script>
$(document).ready(function(){
	
	$('#attach_file').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'wav':
			case 'wmv':
			case 'mp3':
			case 'mp4':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
	
});	
</script>