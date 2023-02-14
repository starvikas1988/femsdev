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

<?php if($bsnl_id!=0){
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
										<td colspan="6" id="theader" style="font-size:30px">BSNL - Call Observation Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($bsnl_id==0){
											$auditorName = get_username();
											//$auditDate = CurrDateMDY(); // It is taking server time 
											$auditDate = GetLocalMDYDate(); // It is taking time accorking to the user location
											$clDate_val='';
										}else{
											if($bsnl['entry_by']!=''){
												$auditorName = $bsnl['auditor_name'];
											}else{
												$auditorName = $bsnl['client_name'];
											}
											$auditDate = mysql2mmddyy($bsnl['audit_date']);
											$clDate_val = mysql2mmddyy($bsnl['call_date']);


										}
										
										/////////////////////////////////////

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_queue = "";
											$record_track = $rand_data['recording_track_id'];
											$call_duration =$rand_data['call_duration'];
											$mobile_no = $rand_data['customer_number'];	
											$sap_id=$rand_data['sap_id_extension'];
											$clDate_val = date('m-d-Y',strtotime($rand_data['call_date']));
											
										} else {
											$agent_id = $bsnl['agent_id'];
											$fusion_id = $bsnl['fusion_id'];
											$agent_name = $bsnl['fname'] . " " . $bsnl['lname'] ;
											$tl_id = $bsnl['tl_id'];
											$tl_name = $bsnl['tl_name'];
											$call_queue = $bsnl['call_queue'];
											$record_track = $bsnl['record_track'];
											
											
											$call_duration = $bsnl['call_duration'];
											$mobile_no = $bsnl['mobile_no'];
											$sap_id=$bsnl['sap_id'];
											if ($bsnl_id == 0) {
												$clDate_val = '';
											} else {
												//$clDate_val =mysqlDt2mmddyy($bsnl['call_date']);
												$clDate_val = date('m-d-Y',strtotime($bsnl['call_date']));
											}
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" required></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" required></td>
										<td>Call Date:</td>
										<td style="width:200px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Week</td>
										<td>
										<select class="form-control"  name="data[week]" required>
											<option value="<?php echo $bsnl['week'] ?>"><?php echo $bsnl['week'] ?></option>
											<option value="">-Select-</option>
											<option value="Week1">Week1</option>
											<option value="Week2">Week2</option>
											<option value="Week3">Week3</option>
											<option value="Week4">Week4</option>
											<option value="Week5">Week5</option>
										</select>
									</td>
										<td>Mobile Number</td>
										<td><input type="number" class="form-control" id="mobile_no" name="data[mobile_no]" value="<?php echo $mobile_no; ?>" required ></td>
										<td>Circle</td>
										<td><input type="text" class="form-control" id="circle" name="data[circle]" value="<?php echo $bsnl['circle'] ?>" required ></td>
									</tr>
									<tr>
										<td>Agent Name:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<?php if($agent_id){ ?>
												<option value="<?php echo $agent_id ?>"><?php echo $agent_name; ?></option>
											   <?php } ?>
												<option value="">--Select--</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $fusion_id; ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $tl_id ?>"><?php echo $tl_name; ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									
									<tr>
										<td>Call Queue:</td>
										<td>
											<select class="form-control" id="call_queue" name="data[call_queue]" required>
											
												<option value="<?php echo $call_queue; ?>"><?php echo $call_queue; ?></option>
												<option value="">-Select-</option>
												<option value="GSM Prepaid">GSM Prepaid</option>
												<option value="Retailer">Retailer</option>
												<option value="GSM Postpaid">GSM Postpaid</option>
												<option value="WI-MAX">WI-MAX</option>
												<option value="Outbound">Outbound</option>
												<option value="Televerification">Televerification</option>
												<option value="CDMA Postpaid">CDMA Postpaid</option>
												<option value="CDMA Prepaid">CDMA Prepaid</option>
												<option value="Blackbary">Blackbary</option>
											</select>
										</td>
										<td >Call Type</td>
										<td >
											<select class="form-control" id="call_type" name="data[call_type]" required>
												<option value="<?php echo $bsnl['call_type'] ?>"><?php echo $bsnl['call_type'] ?></option>
												<option value="">Select</option>
												<option value="Query">Query</option>
												<option value="Request">Request</option>
												<option value="Complaint">Complaint</option>
											</select>
										</td>
										<td>Sub-type of Call:</td>
										<td><input type="text" class="form-control" id="sub_type" name="data[sub_type]" value="<?php echo $bsnl['sub_type'] ?>" required ></td>
									</tr>

									<tr>
										<td>Recording Track ID:</td>
										<td><input type="text" class="form-control" id="record_track" name="data[record_track]" value="<?php echo $record_track; ?>" required ></td>
										<td>Category:</td>
										<td><input type="text" class="form-control" name="data[category]" value="<?php echo $bsnl['category'] ?>" required ></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required ></td>
									</tr>
									<tr>
										<td>Sap ID:</td>
										<td><input type="text" class="form-control" id="sap_id" name="data[sap_id]" value="<?php echo $sap_id;?>" required ></td>
										<td>Asst. Manager:</td>
										<td><input type="text" class="form-control" name="data[asst_manager]" value="<?php echo $bsnl['asst_manager'] ?>" required ></td>
										<td>DNIS (VDN):</td>
										<td><input type="text" class="form-control" id="dnis" name="data[dnis]" value="<?php echo $bsnl['dnis'] ?>" required ></td>
									</tr>
									<tr>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
											<option value="<?php echo $bsnl['audit_type'] ?>"><?php echo $bsnl['audit_type'] ?></option>	
											<option value="">-Select-</option>
											<option <?php echo $bsnl['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $bsnl['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $bsnl['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
											<option <?php echo $bsnl['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $bsnl['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" required>
												<option value="<?php echo $bsnl['auditor_type'] ?>"><?php echo $bsnl['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
												<option <?php echo $bsnl['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $bsnl['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $bsnl['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $bsnl['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $bsnl['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="bsnl_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $bsnl['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="bsnl_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $bsnl['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="bsnl_overall_score" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $bsnl['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td colspan=3>Parameter</td>
										<td>Rating</td>
										<td colspan=2>Remarks</td>
									</tr>
									<tr>
										<td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Call Opening</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Greeted Customer, State BSNL Name, Started Call With Smile</td>
										<td>
											<select class="form-control bsnl_point" name="data[greeted_customer]" required>
												<option bsnl_val=6 <?php echo $bsnl['greeted_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=6 <?php echo $bsnl['greeted_customer'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['greeted_customer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt1]" >
												<option value="<?php echo $bsnl['cmt1'] ?>"><?php echo $bsnl['cmt1'] ?></option>
												<option value="">Select</option>
												<option value="Did not open the Call with Smile">Did not open the Call with Smile</option>
												<option value="Did not use proper Script">Did not use proper Script</option>
												<option value="Delayed Opening (More than 5 Secs)">Delayed Opening (More than 5 Secs)</option>
												<option value="Did not open the call on customer selection languages">Did not open the call on customer selection languages</option>

												<option value="Self introduction missing">Self introduction missing</option>
												<option value="Brand name missing">Brand name missing</option>
												<option value="Opening not clear">Opening not clear</option>
												<option value="Opening greeting missing">Opening greeting missing</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Introduced Self (First Name)</td>
										<td>
											<select class="form-control bsnl_point " name="data[introduced_self]" required>
												<option bsnl_val=4 <?php echo $bsnl['introduced_self'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['introduced_self'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['introduced_self'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt2]" >
												<option value="<?php echo $bsnl['cmt2'] ?>"><?php echo $bsnl['cmt2'] ?></option>
												<option value="">Select</option>
												<option value="Did not Introduced himself">Did not Introduced himself</option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td class="eml1" colspan=3>Asked Callers Name</td>
										<td>
											<select class="form-control bsnl_point " name="data[asked_callers_name]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['asked_callers_name'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['asked_callers_name'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['asked_callers_name'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt3]" >
												<option value="<?php echo $bsnl['cmt3'] ?>"><?php echo $bsnl['cmt3'] ?></option>
												<option value="">Select</option>
												<option value="Did not ask caller Name">Did not ask caller Name</option>
												<option value="Name not ask due to down time">Name not ask due to down time</option>
												<option value="Name conform from customer side">Name conform from customer side</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3 style="color:#FF0000" >Asked caller the required verification questions (If any) </td>
										<td>
											<select class="form-control bsnl_point " id="bsnl_AF1" name="data[asked_verification_questions]" required>
												
												<option bsnl_val=2 <?php echo $bsnl['asked_verification_questions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												
												<option bsnl_val=2 <?php echo $bsnl['asked_verification_questions'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['asked_verification_questions'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt4]" >
												<option value="<?php echo $bsnl['cmt4'] ?>"><?php echo $bsnl['cmt4'] ?></option>
												<option value="">Select</option>
												<option value="Missed out on Security Check">Missed out on Security Check</option>
												<option value="Security Check done but details Mismatch">Security Check done but details Mismatch</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Call Type Identification</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Asked Caller Purpose of the Call</td>
										<td>
											<select class="form-control bsnl_point " name="data[purpose_of_call]" required>
												<option bsnl_val=4 <?php echo $bsnl['purpose_of_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['purpose_of_call'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['purpose_of_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt5]" >
												<option value="<?php echo $bsnl['cmt5'] ?>"><?php echo $bsnl['cmt5'] ?></option>
												<option value="">Select</option>
												<option value="Did not asked purpose of the call">Did not asked purpose of the call</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Verified the purpose with the caller (Paraphrase)</td>
										<td>
											<select class="form-control bsnl_point " name="data[verified_the_purpose]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['verified_the_purpose'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['verified_the_purpose'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['verified_the_purpose'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt6]" >
												<option value="<?php echo $bsnl['cmt6'] ?>"><?php echo $bsnl['cmt6'] ?></option>
												<option value="">Select</option>
												<option value="Did Not Paraphrase the customer's query">Did Not Paraphrase the customer's query</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Identified the call type and identified the process to be followed</td>
										<td>
											<select class="form-control bsnl_point " name="data[identified_call_type]" required>
												<option bsnl_val=4 <?php echo $bsnl['identified_call_type'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['identified_call_type'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['identified_call_type'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt7]" >
												<option value="<?php echo $bsnl['cmt7'] ?>"><?php echo $bsnl['cmt7'] ?></option>
												<option value="">Select</option>
												<option value="Did not identified the Call Type">Did not identified the Call Type</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3 style="color:#FF0000">Identified the IT/Tools to be used</td>
										<td>
											<select class="form-control bsnl_point " id="bsnl_AF2" name="data[identified_it_systems]" required>
												<option bsnl_val=2 <?php echo $bsnl['identified_it_systems'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $bsnl['identified_it_systems'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['identified_it_systems'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt8]" >
												<option value="<?php echo $bsnl['cmt8'] ?>"><?php echo $bsnl['cmt8'] ?></option>
												<option value="">Select</option>
												<option value="Did not Identified the IT/Tools">Did not Identified the IT/Tools</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Process Adherence</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Followed all process steps/Activities in sequence			
										</td>
										<td>
											<select class="form-control bsnl_point "  name="data[followed_process]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['followed_process'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['followed_process'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['followed_process'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt9]" >
												<option value="<?php echo $bsnl['cmt9'] ?>"><?php echo $bsnl['cmt9'] ?></option>
												<option value="">Select</option>
												<option value="Process Steps/Sequence not follow">Process Steps/Sequence not follow</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Navigate the system without any errors</td>
										<td>
											<select class="form-control bsnl_point " name="data[navigate_system]" required>
												
												<option bsnl_val=2 <?php echo $bsnl['navigate_system'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $bsnl['navigate_system'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['navigate_system'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt10]" >
												<option value="<?php echo $bsnl['cmt10'] ?>"><?php echo $bsnl['cmt10'] ?></option>
												<option value="">Select</option>
												<option value="Did not Navigate the System without Error">Did not Navigate the System without Error</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Procured the required information from customer</td>
										<td>
											<select class="form-control bsnl_point " name="data[procured_information]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['procured_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['procured_information'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['procured_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt11]" >
												<option value="<?php echo $bsnl['cmt11'] ?>"><?php echo $bsnl['cmt11'] ?></option>
												<option value="">Select</option>
												<option value="Incomplete Probing on Call">Incomplete Probing on Call</option>
												<option value="Irrelevant Probing on call">Irrelevant Probing on call</option>
												<option value="Probing Not Done">Probing Not Done</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Utilized all information system access before escalation</td>
										<td>
											<select class="form-control bsnl_point " name="data[utilized_all_information]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['utilized_all_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['utilized_all_information'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['utilized_all_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt12]" >
												<option value="<?php echo $bsnl['cmt12'] ?>"><?php echo $bsnl['cmt12'] ?></option>
												<option value="">Select</option>
												<option value="Did not use Proper Escalation Scripts">Did not use Proper Escalation Scripts</option>
												<option value="Did not Try to Deescalate the Customer">Did not Try to Deescalate the Customer</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Verbal Contact</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3 style="color:#FF0000">Used approved Questions/Language</td>
										<td>
											<select class="form-control bsnl_point " id="bsnl_AF3" name="data[used_approved_questions]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['used_approved_questions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['used_approved_questions'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['used_approved_questions'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt13]" >
												<option value="<?php echo $bsnl['cmt13'] ?>"><?php echo $bsnl['cmt13'] ?></option>
												<option value="">Select</option>
												<option value="Did not Speak in Preffered language">Did not Speak in Preffered language</option>
												<option value="Rude/Impolite/Sarcastic/Abusive on Call">Rude/Impolite/Sarcastic/Abusive on Call</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Demonstrated active listening Skills</td>
										<td>
											<select class="form-control bsnl_point " name="data[demonstrated_active]" required>
												
												<option bsnl_val=2 <?php echo $bsnl['demonstrated_active'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $bsnl['demonstrated_active'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['demonstrated_active'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt14]" >
												<option value="<?php echo $bsnl['cmt14'] ?>"><?php echo $bsnl['cmt14'] ?></option>
												<option value="">Select</option>
												<option value="Did not Listen the Customer Carefully">Did not Listen the Customer Carefully</option>
												<option value="Interruption on Call">Interruption on Call</option>
												<option value="Lack of Clarity of Speech">Lack of Clarity of Speech</option>
												<option value="Hurry to Close the call">Hurry to Close the call</option>
												<option value="Use Jargons/forgons on calls">Use Jargons/forgons on calls</option>
												<option value="Not attentive on call">Not attentive on call</option>
												<option value="Fast Rate Of Speech">Fast Rate Of Speech</option>
												<option value="Incorrect Salutation used on call">Incorrect Salutation used on call</option>
												<option value="Parallel Talk ,Overlapping on call">Parallel Talk ,Overlapping on call</option>
												<option value="Pleasantries missing on call">Pleasantries missing on call</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3 >Used Confidence empathy wordings</td>
										<td>
											<select class="form-control bsnl_point " name="data[used_confidence_empathy]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['used_confidence_empathy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['used_confidence_empathy'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['used_confidence_empathy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt15]" >
												<option value="<?php echo $bsnl['cmt15'] ?>"><?php echo $bsnl['cmt15'] ?></option>
												<option value="">Select</option>
												<option value="Associate Fumbling on Call">Associate Fumbling on Call</option>
												<option value="Associate did not sound confident on call">Associate did not sound confident on call</option>
												<option value="Empathy Missing on Call">Empathy Missing on Call</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Gave appology/reassurence/appropriate response	</td>
										<td>
											<select class="form-control bsnl_point " name="data[gave_appology]" required>
												
												<option bsnl_val=2 <?php echo $bsnl['gave_appology'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=2 <?php echo $bsnl['gave_appology'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['gave_appology'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt16]" >
												<option value="<?php echo $bsnl['cmt16'] ?>"><?php echo $bsnl['cmt16'] ?></option>
												<option value="">Select</option>
												<option value="Unappropriate response on call">Unappropriate response on call</option>
												<option value="Apology missing on call">Apology missing on call</option>
												<option value="Unintresting tone on call">Unintresting tone on call</option>
												<option value="Casual on call">Casual on call</option>
												<option value="Un-necessary Apology on call">Un-necessary Apology on call</option>
												<option value="Acknowledgement and Assurance Missing ">Acknowledgement and Assurance Missing </option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td class="eml1" colspan=3>Explained hold time or dead air </td>
										<td>
											<select class="form-control bsnl_point " name="data[explained_hold_time]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['explained_hold_time'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['explained_hold_time'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['explained_hold_time'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt17]" >
												<option value="<?php echo $bsnl['cmt17'] ?>"><?php echo $bsnl['cmt17'] ?></option>
												<option value="">Select</option>
												<option value="Did not use Proper Hold Script">Did not use Proper Hold Script</option>
												<option value="Explained Dead Air more than 30 Secs">Explained Dead Air more than 30 Secs</option>
												<option value="Unexplained Dead Air more than 10 Secs">Unexplained Dead Air more than 10 Secs</option>
												<option value="Didn’t refresh hold within stipulated timeline">Didn’t refresh hold within stipulated timeline</option>
												<option value="Hold/Unhold script not given">Hold/Unhold script not given</option>
												<option value="Didn’t follow Proper Unhold script">Didn’t follow Proper Unhold script</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3 style="color:#FF0000">Upheld BSNL's Positive Image</td>
										<td>
											<select class="form-control bsnl_point " id="bsnl_AF4" name="data[upheld_positive_image]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['upheld_positive_image'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['upheld_positive_image'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['upheld_positive_image'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt18]" >
												<option value="<?php echo $bsnl['cmt18'] ?>"><?php echo $bsnl['cmt18'] ?></option>
												<option value="">Select</option>
												<option value="Did not upheld BSNLs Positive Image">Did not upheld BSNLs Positive Image</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Call Control</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Maintained focus on Caller's Problem</td>
										<td>
											<select class="form-control bsnl_point " name="data[maintained_focus]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['maintained_focus'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['maintained_focus'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['maintained_focus'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt19]" >
												<option value="<?php echo $bsnl['cmt19'] ?>"><?php echo $bsnl['cmt19'] ?></option>
												<option value="">Select</option>
												<option value="Did not Maintained Focus on Callers Problem">Did not Maintained Focus on Callers Problem</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Identified other issues raised (If any) during the call and sequenced each issue</td>
										<td>
											<select class="form-control bsnl_point " name="data[identify_other_issues]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['identify_other_issues'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['identify_other_issues'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['identify_other_issues'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt20]" >
												<option value="<?php echo $bsnl['cmt20'] ?>"><?php echo $bsnl['cmt20'] ?></option>
												<option value="">Select</option>
												<option value="Multiple Query Resolution not provided">Multiple Query Resolution not provided</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3 style="color:#FF0000">Gave Accurate information/Next step on each Issue</td>
										<td>
											<select class="form-control bsnl_point " id="bsnl_AF5" name="data[gave_accurate_information]" required>
												
												<option bsnl_val=6 <?php echo $bsnl['gave_accurate_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=6 <?php echo $bsnl['gave_accurate_information'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['gave_accurate_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt21]" >
												<option value="<?php echo $bsnl['cmt21'] ?>"><?php echo $bsnl['cmt21'] ?></option>
												<option value="">Select</option>
												<option value="Inaccurate Information Provided">Inaccurate Information Provided</option>
												<option value="Incomplete information provided">Incomplete information provided</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Transfer call Appropriately (If Required)</td>
										<td>
											<select class="form-control bsnl_point " name="data[transferred_call]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['transferred_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['transferred_call'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['transferred_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt22]" >
												<option value="<?php echo $bsnl['cmt22'] ?>"><?php echo $bsnl['cmt22'] ?></option>
												<option value="">Select</option>
												<option value="Transfer Calls Unnecessarily">Transfer Calls Unnecessarily</option>
												<option value="Blind Transfer">Blind Transfer</option>
											</select>
										</td>
									</tr>
                                     <tr>
										<td class="eml1" colspan=6 style="background-color:#3f5691; color: white;">Call Closing</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Gave SR Number (If Required)</td>
										<td>
											<select class="form-control bsnl_point" name="data[gave_sr_number]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['gave_sr_number'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['gave_sr_number'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['gave_sr_number'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt23]" >
												<option value="<?php echo $bsnl['cmt23'] ?>"><?php echo $bsnl['cmt23'] ?></option>
												<option value="">Select</option>
												<option value="Did not Provide Complaint/Request Number to the Customer">Did not Provide Complaint/Request Number to the Customer</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Thanked the caller for calling</td>
										<td>
											<select class="form-control bsnl_point" name="data[thanked_caller]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['thanked_caller'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['thanked_caller'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['thanked_caller'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt24]" >
												<option value="<?php echo $bsnl['cmt24'] ?>"><?php echo $bsnl['cmt24'] ?></option>
												<option value="">Select</option>
												<option value="Did not use Proper Closing Script">Did not use Proper Closing Script</option>
												<option value="Agent didn’t thank the customer">Agent didn’t thank the customer</option>
												<option value="CSAT Script not pitched">CSAT Script not pitched</option>
												<option value="Brand name missing">Brand name missing</option>
												<option value="Greeting missing">Greeting missing</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Waited for caller to hang-up and appropriately closed the call</td>
										<td>
											<select class="form-control bsnl_point" name="data[waited_for_hangup]" required>
												
												<option bsnl_val=4 <?php echo $bsnl['waited_for_hangup'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=4 <?php echo $bsnl['waited_for_hangup'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['waited_for_hangup'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt25]" >
												<option value="<?php echo $bsnl['cmt25'] ?>"><?php echo $bsnl['cmt25'] ?></option>
												<option value="">Select</option>
												<option value="Did not hang-up the Call as per Process">Did not hang-up the Call as per Process</option>
												<option value="FA not given">FA not given</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=3 style="color:#FF0000">Captured accurate notes in CRM</td>
										<td>
											<select class="form-control bsnl_point" id="bsnl_AF6" name="data[accurate_notes]" required>
												
												<option bsnl_val=6 <?php echo $bsnl['accurate_notes'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option bsnl_val=6 <?php echo $bsnl['accurate_notes'] == "No"?"selected":"";?> value="No">No</option>
												<option bsnl_val=0 <?php echo $bsnl['accurate_notes'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" name="data[cmt26]" >
												<option value="<?php echo $bsnl['cmt26'] ?>"><?php echo $bsnl['cmt26'] ?></option>
												<option value="">Select</option>
												<option value="No Tagging Done on Call">No Tagging Done on Call</option>
												<option value="Inaccurate Tagging done on call">Inaccurate Tagging done on call</option>
												<option value="Incorrect Circle selected">Incorrect Circle selected</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control"   name="data[call_summary]"><?php echo $bsnl['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control"   name="data[feedback]"><?php echo $bsnl['feedback'] ?></textarea></td>
									</tr>

									<tr>
										<td>Notes:</td>
										<td colspan="2"><textarea class="form-control"   name="data[notes]"><?php echo $bsnl['notes'] ?></textarea></td>
										
									</tr>
									
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($bsnl_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($bsnl['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$bsnl['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_bsnl/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_bsnl/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($bsnl_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $bsnl['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $bsnl['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $bsnl['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $bsnl['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($bsnl_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($bsnl['entry_date'],72) == true){ ?>
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
