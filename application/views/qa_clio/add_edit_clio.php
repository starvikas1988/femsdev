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

input[type='checkbox'] { 
margin-left:5px;
}
span.checkbox-width {
    width: 400px;
    display: inline-block;
}
 input[type="file"] {
    padding: 10px;
}

input#attach_file {
    padding: 10px;
}

/*========*/


.form-check  label{
	font-weight: 500!important;
}
</style>

<?php if($gds_id!=0){
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
										<td colspan="6" id="theader" style="font-size:30px">CENTRELAKE IMAGING AND ONCOLOGY QUALITY FORM</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($gds_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($clio['entry_by']!=''){
												$auditorName = $clio['auditor_name'];
											}else{
												$auditorName = $clio['client_name'];
											}
											$auditDate = mysql2mmddyy($clio['audit_date']);
											$clDate_val = mysql2mmddyy($clio['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td style="width:200px;"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Transaction Date & Time:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:200px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $clio['agent_id'] ?>"><?php echo $clio['fname']." ".$clio['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $clio['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<input type="hidden" id="tl_id" name="data[tl_id]" class="form-control" value="<?php echo $clio['tl_id']; ?>">
											<input type="text" id="tl_name" class="form-control" value="<?php echo $clio['tl_name']; ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Query Type:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[query_type]" value="<?php echo $clio['query_type'] ?>" required ></td>
										<td>Query Sub Type:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[query_sub_type]" value="<?php echo $clio['query_sub_type'] ?>" required ></td>
										<!-- <td>Property:</td>
										<td><input type="text" class="form-control" name="data[property]" value="<?php //echo $clio['property'] ?>" required ></td> -->
										<td>Stat / Non-Stat<span style="font-size:24px;color:red">*</span></td>
										<td>
									        <select style="color:black;" class="form-control" name="data[stat]" required>
												<option value="">-Select-</option>
												<option <?php echo $clio['stat'] == "stat"?"selected":"";?> value="stat">Stat</option>
												<option <?php echo $clio['stat'] == "non_stat"?"selected":"";?> value="non_stat">Non-Stat</option>
												<option <?php echo $clio['stat'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration"  name="data[call_duration]" value="<?php echo $clio['call_duration'] ?>" required ></td>
										<td>Call Type<span style="font-size:24px;color:red">*</span></td>
										<td>
									        <select style="color:black;" class="form-control" name="data[call_type]" required>
												<option value="">-Select-</option>
												<option <?php echo $clio['call_type'] == "General"?"selected":"";?> value="General">General</option>
												<option <?php echo $clio['call_type'] == "Successful"?"selected":"";?> value="Successful">Successful</option>
												<option <?php echo $clio['call_type'] == "Unsuccessful"?"selected":"";?> value="Unsuccessful">Unsuccessful</option>
											</select> 
										</td>
										<td>Sampling:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="data[sampling]" value="<?php echo $clio['sampling'] ?>" required ></td>
									</tr>
									<tr>
										<td>Reference ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[reference_id]" value="<?php echo $clio['reference_id'] ?>" required ></td>
										<td>Total Opportunity:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[total_opportunity]" value="<?php echo $clio['total_opportunity'] ?>" required ></td>
										<td>Auto Fail<span style="font-size:24px;color:red">*</span></td>
										<td>
									     <select style="color:black;" class="form-control jurry_points" value="null" id="clioAF1" name="data[auto_fail]" required>
												<option value="">-Select-</option>
												<option ji_val=0 <?php echo $clio['auto_fail'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option  ji_val=0 <?php echo $clio['auto_fail'] == "No"?"selected":"";?> value="No">No</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $clio['audit_type'] ?>"><?php echo $clio['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="WOW Call">WOW Call</option>
												<option value="Escalation Audit">Escalation Audit</option>
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
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $clio['voc'] ?>"><?php echo $clio['voc'] ?></option>
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
										<td>LOB:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[lob]" required>
												<option value="<?php echo $clio['lob'] ?>"><?php echo $clio['lob'] ?></option>
												<option value="">-Select-</option>
												<option value="P003">P003</option>
												<option value="P107">P107</option>
												<option value="P005">P005</option>
											</select>
										</td>

										<td>Inbound/Outbound:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[in_out]" required>
												<option value="<?php echo $clio['in_out'] ?>"><?php echo $clio['in_out'] ?></option>
												<option value="">-Select-</option>
												<option value="Inbound">Inbound </option>
												<option value="Outbound">Outbound</option>
												
											</select>
										</td>

										<td>KPI-ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[kpi_acpt]" required>
												    <option value="">-Select-</option>
												    <option value="Agent" <?= ($clio['kpi_acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Customer" <?= ($clio['kpi_acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Process" <?= ($clio['kpi_acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Technology" <?= ($clio['kpi_acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA" <?= ($clio['kpi_acpt']=="NA")?"selected":"" ?>>NA</option>
											</select>
											</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="jurys_inn_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $clio['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="jurys_inn_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $clio['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="jurys_inn_overall_score" name="data[overall_score]" class="form-control gds_prearrival_fatal" style="font-weight:bold" value="<?php echo $clio['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td colspan=3>PARAMETER</td>
										<td>STATUS</td>
										<td colspan=2>COMMENT</td>
										
									</tr>
									<tr><td colspan=6 style="background-color:#7DCEA0">Compliance Critical</td></tr>
									<tr>
										<td class="eml1" colspan=3>Did the CSR adhere to all Authentication and Security Policies of the account member?</td>
										<td>
											<select class="form-control jurry_points compliance" name="data[do_csr_adhere]" required>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $clio['do_csr_adhere'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $clio['do_csr_adhere'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_csr_adhere'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $clio['cmt1'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Properly verifies the account holder information before providing/discussing any account information.</td>
										<td>
											<select class="form-control jurry_points compliance" name="data[properly_verifies_account_holder]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['properly_verifies_account_holder'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['properly_verifies_account_holder'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['properly_verifies_account_holder'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $clio['cmt2'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>For account changes, caller should be authorized on the account (ie,wife or dependent)</td>
										<td>
											<select class="form-control jurry_points compliance" name="data[is_authorized_account]" required>
												<option value="">-Select-</option>
												<option ji_val=2 <?php echo $clio['is_authorized_account'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $clio['is_authorized_account'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['is_authorized_account'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $clio['cmt3'] ?>"></td>
									</tr>
									<!-- <tr>
										<td class="eml1" colspan=3>Obtain verbal permission from an authenticated account owner before providing any account information.</td>
										<td>
											<select class="form-control jurry_points compliance" name="data[obtain_verbal_permission]" required>
												<option value="">-Select-</option>
												<option ji_val=2 <?php //echo $clio['obtain_verbal_permission'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php //echo $clio['obtain_verbal_permission'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php //echo $clio['obtain_verbal_permission'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php //echo $clio['cmt4'] ?>"></td>
									</tr> -->
									<tr>
										<td class="eml1" colspan=3>Did the CSR greets the caller by mentioning the branding in the opeaning spiel and thank the caller on the closing spiel?</td>
										<td>
											<select class="form-control jurry_points compliance" name="data[closing_spiel]" required>
												<option value="">-Select-</option>
												<option ji_val=2 <?php echo $clio['closing_spiel'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $clio['closing_spiel'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['closing_spiel'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt20]" value="<?php echo $clio['cmt20'] ?>"></td>
									</tr>

									<tr><td colspan=6 style="background-color:#7DCEA0">CUSTOMER CRITICAL</td></tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent check if the order is STAT?</td>
										<td>
											<select class="form-control jurry_points customer" name="data[do_agent_check]" required>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $clio['do_agent_check'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $clio['do_agent_check'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_agent_check'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $clio['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent show empathy and acknowledge patient's concern?</td>
										<td>
											<select class="form-control jurry_points customer" name="data[do_show_empathy]" required>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $clio['do_show_empathy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $clio['do_show_empathy'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_show_empathy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $clio['cmt6'] ?>"></td>
										<!-- <td>Business Critical</td> -->
									</tr>
									<?php 
									// if($od_voice_id==0){
										
										$chk_array1="";
										$clio['check_list1'];
										$chk_array1=explode(',', $clio['check_list1']);
										
										//}

									?>
									<tr>
										<td class="eml1" colspan=3 >Did the agent utilize all needed information before scheduling an appointment?</td>

										<td colspan="" rowspan="9">
											<select class="form-control jurry_points customer" name="data[do_agent_utilize_information]" required>
												<option value="">-Select-</option>
												<option ji_val=20 <?php echo $clio['do_agent_utilize_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=20 <?php echo $clio['do_agent_utilize_information'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_agent_utilize_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2 rowspan="9"><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $clio['cmt7'] ?>"></td>
										
									</tr>
									<!-- checkbox start -->
									<tr>
										<td colspan="2" class="form-check">
									
											<label class="form-check-label" for="flexCheckDefault">
									    Doctor
									  </label>
									</td>
									<td>
									  <input class="form-check-input" type="checkbox" name="check_list1[]" <?php if(in_array("Doctor", $chk_array1)) { echo 'checked'; }?> value="Doctor" id="flexCheckDefault">
									  
								
  
										</td>
									</tr>
										<tr>
										<td colspan="2" class="form-check">
									
											<label class="form-check-label" for="flexCheckDefault">
									    Patient Info
									  </label>
									</td>
									<td>
									  <input class="form-check-input" type="checkbox" name="check_list1[]" <?php if(in_array("Patient_Info", $chk_array1)) { echo 'checked'; }?> value="Patient_Info" id="flexCheckDefault">
									  
								
  
										</td>
									</tr>
										<tr>
										<td colspan="2" class="form-check">
									
											<label class="form-check-label" for="flexCheckDefault">
									    Eligibility Related
									  </label>
									</td>
									<td>
									  <input class="form-check-input" type="checkbox" name="check_list1[]" <?php if(in_array("Eligibility_Related", $chk_array1)) { echo 'checked'; }?> value="Eligibility_Related" id="flexCheckDefault">
									  
								
  
										</td>
									</tr>
										<tr>
										<td colspan="2" class="form-check">
									
											<label class="form-check-label" for="flexCheckDefault">
									    Referral
									  </label>
									</td>
									<td>
									  <input class="form-check-input" type="checkbox" name="check_list1[]" <?php if(in_array("Referral", $chk_array1)) { echo 'checked'; }?>  value="Referral" id="flexCheckDefault">
									  
								
  
										</td>
									</tr>
									<tr>
										<td colspan="2" class="form-check">
									
											<label class="form-check-label" for="flexCheckDefault">
									    Screening Questions
									  </label>
									</td>
									<td>
									  <input class="form-check-input" type="checkbox" name="check_list1[]" <?php if(in_array("Screening_Questions", $chk_array1)) { echo 'checked'; }?> value="Screening_Questions" id="flexCheckDefault">
									  
								
  
										</td>
									</tr>
										<tr>
										<td colspan="2" class="form-check">
									
											<label class="form-check-label" for="flexCheckDefault">
									    Document Info
									  </label>
									</td>
									<td>
									  <input class="form-check-input" type="checkbox" name="check_list1[]" <?php if(in_array("Document_Info", $chk_array1)) { echo 'checked'; }?>  value="Document_Info" id="flexCheckDefault">
									  
								
  
										</td>
									</tr>
										<tr>
										<td colspan="2" class="form-check">
									
											<label class="form-check-label" for="flexCheckDefault">
									    Scheduling
									  </label>
									</td>
									<td>
									  <input class="form-check-input" type="checkbox" name="check_list1[]" <?php if(in_array("Scheduling", $chk_array1)) { echo 'checked'; }?> value="Scheduling" id="flexCheckDefault">
									  
								
  
										</td>
									</tr>
										<tr>
										<td colspan="2" class="form-check">
									
											<label class="form-check-label" for="flexCheckDefault">
									    Insurance
									  </label>
									</td>
									<td>
									  <input class="form-check-input" type="checkbox" name="check_list1[]" <?php if(in_array("Insurance", $chk_array1)) { echo 'checked'; }?> value="Insurance" id="flexCheckDefault">
									  
								
  
										</td>
									</tr>
											<!-- checkbox end -->
								
									<tr>
										<td class="eml1" colspan=3>Did the agent observe proper Hold Procedure and avoid long silences?</td>
										<td>
											<select class="form-control jurry_points customer" id="" name="data[do_proper_hold_procedure]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['do_proper_hold_procedure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['do_proper_hold_procedure'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_proper_hold_procedure'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $clio['cmt8'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent maintain a positive interaction during the call?</td>
										<td>
											<select class="form-control jurry_points customer" name="data[do_maintain_positive_interaction]" required>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $clio['do_maintain_positive_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $clio['do_maintain_positive_interaction'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_maintain_positive_interaction'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $clio['cmt9'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent asked Covid screening questions?</td>
										<td>
											<select class="form-control jurry_points customer" id="" name="data[do_ask_covid_question]" required>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $clio['do_ask_covid_question'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $clio['do_ask_covid_question'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_ask_covid_question'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $clio['cmt10'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent provide accurate reminders for the patient?</td>
										<td>
											<select class="form-control jurry_points customer" id="" name="data[do_provide_accurate_reminders]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['do_provide_accurate_reminders'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['do_provide_accurate_reminders'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_provide_accurate_reminders'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $clio['cmt12'] ?>"></td>
										
									</tr>

									<!-- <tr>
										<td class="eml1" colspan=3>Did the agent ask relevant probing questions?</td>
										<td>
											<select class="form-control jurry_points customer" id="" name="data[ask_relevant_probing]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php //echo $clio['ask_relevant_probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php //echo $clio['ask_relevant_probing'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php //echo $clio['ask_relevant_probing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt20]" value="<?php //echo $clio['cmt20'] ?>"></td>
										
									</tr> -->
									
									</tr><tr><td colspan=6 style="background-color:#7DCEA0">BUSINESS CRITICAL</td></tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent select the correct order status and left account notes?</td>
										<td>
											<select class="form-control jurry_points business" name="data[do_select_correct_order_status]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['do_select_correct_order_status'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['do_select_correct_order_status'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_select_correct_order_status'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt21]" value="<?php echo $clio['cmt21'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent check if CPT and diagnosis are both correct?</td>
										<td>
											<select class="form-control jurry_points business" name="data[do_check_cpt_diagnosis]" required>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $clio['do_check_cpt_diagnosis'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $clio['do_check_cpt_diagnosis'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_check_cpt_diagnosis'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $clio['cmt13'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent update the patient demographic information?</td>
										<td>
											<select class="form-control jurry_points business" name="data[do_update_patient_demographic]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['do_update_patient_demographic'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['do_update_patient_demographic'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_update_patient_demographic'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $clio['cmt14'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent follow up with necessary documents? (Going above and Beyond)</td>
										<td>
											<select class="form-control jurry_points business" name="data[do_check_insurance_auth]" required>
												<option value="">-Select-</option>
												<option ji_val=20 <?php echo $clio['do_check_insurance_auth'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=20 <?php echo $clio['do_check_insurance_auth'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_check_insurance_auth'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $clio['cmt15'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent offer alternatives to the patient?</td>
										<td>
											<select class="form-control jurry_points business" name="data[do_check_demog_prescription]" required>
												<option value="">-Select-</option>
												<option ji_val=20 <?php echo $clio['do_check_demog_prescription'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=20 <?php echo $clio['do_check_demog_prescription'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_check_demog_prescription'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $clio['cmt16'] ?>"></td>
										
									</tr>
									<!-- <tr>
										<td class="eml1" colspan=3>Did the agent check expiration date of the order?</td>
										<td>
											<select class="form-control jurry_points business" name="data[do_check_expire_date_order]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['do_check_expire_date_order'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['do_check_expire_date_order'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_check_expire_date_order'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $clio['cmt17'] ?>"></td>
										
									</tr> -->
									<tr>
										<td class="eml1" colspan=3>Did the agent verify if it needs to be sent to corrections or pre-cert?</td>
										<td>
											<select class="form-control jurry_points business" name="data[do_verify_need_sent_correction]" required>
												<option value="">-Select-</option>
												<option ji_val=1 <?php echo $clio['do_verify_need_sent_correction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $clio['do_verify_need_sent_correction'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_verify_need_sent_correction'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $clio['cmt18'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Did the agent make sure to set up the correct Modality for the patient?</td>
										<td>
											<select class="form-control jurry_points business" name="data[do_make_setup_correct_modality]" required>
												<option value="">-Select-</option>
												<option ji_val=5 <?php echo $clio['do_make_setup_correct_modality'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=5 <?php echo $clio['do_make_setup_correct_modality'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['do_make_setup_correct_modality'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $clio['cmt19'] ?>"></td>
										
									</tr>
									
									</tr><tr><td colspan=6 style="background-color:#7DCEA0"></td></tr>

									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>

									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned"></td><td>Earned:</td><td id="busiJiCisEarned"></td><td>Earned:</td><td id="complJiCisEarned"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible"></td><td>Possible:</td><td id="busiJiCisPossible"></td><td>Possible:</td><td id="complJiCisPossible"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="data[customer_score]" value="<?php echo $clio['customer_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="data[business_score]" value="<?php echo $clio['business_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="data[compliance_score]" value="<?php echo $clio['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control"   name="data[call_summary]"><?php echo $clio['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control"   name="data[feedback]"><?php echo $clio['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Analytics:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[call_analytics]" required>
											
											    <option value="">-Select-</option>
											    <option value="Customer Experience" <?= ($clio['call_analytics']=="Customer Experience")?"selected":"" ?>>Customer Experience</option>
												<option value="Csat" <?= ($clio['call_analytics']=="Csat")?"selected":"" ?>>Csat</option>
												<option value="Nps" <?= ($clio['call_analytics']=="Nps")?"selected":"" ?>>Nps</option>
												<option value="Issue resolution" <?= ($clio['call_analytics']=="Issue resolution")?"selected":"" ?>>Issue resolution</option>
												<option value="Repeat Caller" <?= ($clio['call_analytics']=="Repeat Caller")?"selected":"" ?>>Repeat Caller</option>
												<option value="High AHT" <?= ($clio['call_analytics']=="High AHT")?"selected":"" ?>>High AHT</option>
												<option value="Low AHT" <?= ($clio['call_analytics']=="Low AHT")?"selected":"" ?>>Low AHT</option>
										</select>
											</td>

										<td>ACPT Level:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[acpt_level]" required>
											    <option value="">-Select-</option>
											    <option value="Level 1" <?= ($clio['acpt_level']=="Level 1")?"selected":"" ?>>Level 1</option>
												<option value="Level 2" <?= ($clio['acpt_level']=="Level 2")?"selected":"" ?>>Level 2</option>
												<option value="Level 3" <?= ($clio['acpt_level']=="Level 3")?"selected":"" ?>>Level 3</option>
										</select>
											</td>	
									</tr>
									
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($gds_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control file-align" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($clio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$clio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_clio/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_clio/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									<?php  if($gds_id!=0){
										if($clio['entry_by']==get_user_id()){ ?>
											<tr><td colspan=2>Edit Upload</td><td colspan=4><input type="file" multiple class="form-control1 file-align" id="fileuploadbasic" name="attach_file[]"></td></tr>
									<?php } 
									} ?>
									
									<?php if($gds_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $clio['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $clio['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $clio['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $clio['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($gds_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($clio['entry_date'],72) == true){ ?>
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
