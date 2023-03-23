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

<?php if($conduent_id!=0){
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
										<td colspan="8" id="theader" style="font-size:40px">Conduent Quality Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($conduent_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											//$go_live_date='';
										}else{
											if($conduent_add['entry_by']!=''){
												$auditorName = $conduent_add['auditor_name'];
											}else{
												$auditorName = $conduent_add['client_name'];
											}
											$auditDate = mysql2mmddyy($conduent_add['audit_date']);
											$clDate_val = mysql2mmddyy($conduent_add['call_date']);
											//$go_live_date = mysql2mmddyy($conduent_add['go_live_date']);
										}

										//VIKAS START//
										//Mobikwik
										$desig1="";
										$designation1="";
										// echo"<pre>";
										// print_r($rand_data);
										// echo"<pre>";
										// die();
										if ($rand_id != 0) {

											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											//$call_queue = "";
											$designation1 = strtoupper($rand_data['designation']);
											$call_duration =$rand_data['aht'];
											$mobile_no = $rand_data['phone_number'];	
											//$disposition=$rand_data['disposition'];
											$clDate_val = date('m-d-Y',strtotime($rand_data['call_date']));
											
										} else {
											$agent_id = $conduent_add['agent_id'];
											$fusion_id = $conduent_add['fusion_id'];
											$agent_name = $conduent_add['fname'] . " " . $conduent_add['lname'] ;
											$tl_id = $conduent_add['tl_id'];
											$tl_name = $conduent_add['tl_name'];
											//$call_queue = $mobikwik_new['call_queue'];
											
											
											$call_duration = $conduent_add['call_duration'];
											$mobile_no = $conduent_add['phone_number'];
											//$disposition=$conduent_add['agent_disposition'];
											if ($conduent_id == 0) {
												$clDate_val = '';
											} else {
												//$clDate_val =mysqlDt2mmddyy($bsnl['call_date']);
												$clDate_val = date('m-d-Y',strtotime($conduent_add['call_date']));
											}
										}
										//VIKAS ENDS//

									?>
									<tr>
										<td colspan="2" style="width:150px">Auditor Name:</td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
									</tr>
									<tr>
										<td colspan="2">Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<?php if($agent_id){ ?>
												<!-- <option value="<?php //echo $conduent_add['agent_id'] ?>"><?php //echo $conduent_add['fname']." ".$conduent_add['lname'] ?></option> -->
												<option value="<?php echo $agent_id  ?>"><?php echo $agent_name; ?></option>
											<?php } ?>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Employee ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="data[employee_id]" value="<?php echo $fusion_id ?>"></td>
										<td>L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<!-- <option value="<?php //echo $conduent_add['tl_id'] ?>"><?php //echo $conduent_add['tl_name'] ?></option> -->
												<option value="<?php echo $tl_id ?>"><?php echo $tl_name; ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>

									<tr>
										<!-- <td>Campaign:</td>
										<td><input type="text" class="form-control" id="campaign" name="data[campaign]" value="<?php //echo $conduent_add['campaign'] ?>" readonly></td> -->
										<td colspan="2">Phone Number:</td>
										<td><input type="number" class="form-control" id="phone_number" name="data[phone_number]" value="<?php echo $mobile_no ?>" required></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration ?>"  required></td>
										<td>Site:</td>
                                        <td colspan="2"><select class="form-control" id="" name="data[site_location]" required>
										<option value="">-Select-</option>
										<!-- <option value="<?php //echo $conduent_add['site_location'] ?>"><?php //echo $conduent_add['site_location'] ?></option> -->
										<option <?php echo $conduent_add['site_location']=='Alabama'?"selected":""; ?> value="Alabama">Alabama</option>
										<option <?php echo $conduent_add['site_location']=='Ohio'?"selected":""; ?> value="Ohio">Ohio</option>
										</select>
										</td>
									</tr>
									<!-- <tr>
										<td>Type of Call:</td>
                                        <td><select class="form-control" id="call_type" name="data[call_type]" required>
												<option value="<?php //echo $conduent_add['call_type'] ?>"><?php //echo $conduent_add['call_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Business">Business</option>
												<option value="Non Business">Non Business</option>
											</select>
										</td>
										<td>Call Record Id:</td>
										<td><input type="text" class="form-control" id="show_pass_fail" name="data[call_record_id]" value="<?php //echo $conduent_add['call_record_id'] ?>" required></td>
										<td>Call Disconnect By:</td>
										<td><input type="text" class="form-control" id="call_disconnect_by" name="data[call_disconnect_by]" value="<?php //echo $conduent_add['call_disconnect_by'] ?>" required></td>
									</tr> -->
									

									<tr>
										<td colspan="2">Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $conduent_add['audit_type'] ?>"><?php echo $conduent_add['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="WOW Call">WOW Call</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<?php if(get_login_type()!="client"){ ?>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
												<?php } ?>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $conduent_add['auditor_type'] ?>"><?php echo $conduent_add['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $conduent_add['voc'] ?>"><?php echo $conduent_add['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="conduent_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $conduent_add['possible_score']; ?>"></td>

										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td colspan="2"><input type="text" readonly id="conduent_earn_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $conduent_add['earned_score']; ?>"></td>

										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2">
											<input type="text" readonly id="conduent_overall_score" name="data[overall_score]" class="form-control conduentFatal" style="font-weight:bold" value="<?php echo $conduent_add['overall_score'] ?>"></td>
									</tr>
									<tr style="background-color:#A9CCE3; font-weight:bold">
										<td>Paramerers</td>
										<td colspan="2">Sub Paramerers</td>
										<td colspan="2">Maximum</td>
										<td>Status</td>
										<td colspan="2">Remark</td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">Courtesy/Politeness</td>
										<td colspan=3>Clearly gave name and Branded.</td>
										<td>10</td>
										<td colspan="2">
											<select class="form-control conduent_points" name="data[name_branded]" required>
												
												<option acm_val=10 <?php echo $conduent_add['name_branded']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=10 <?php echo $conduent_add['name_branded']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['name_branded']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="4" ><textarea name="data[courtesy_comment]" class="form-control"><?php echo $conduent_add['courtesy_comment'] ?></textarea></td>
									</tr>
									<tr>
										
										<td colspan=3>Did CSP demonstrate a good tone of voice throughout the call?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[throughout]" required>
												
												<option acm_val=5 <?php echo $conduent_add['throughout']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['throughout']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['throughout']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										
										<td colspan=3>Did CSP properly verify account & make appropriate updates if necessary?</td>
										<td>10</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[necessary]" required>
												
                                                <option acm_val=10 <?php echo $conduent_add['necessary']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=10 <?php echo $conduent_add['necessary']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['necessary']=='N/A'?"selected":""; ?> value="N/A">N/A</option>

											</select>
										</td>
									</tr>

									<tr>
										
										<td colspan=3>Did CSP deliver assurance statement after purpose?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[purpose]" required>
												
												<option acm_val=5 <?php echo $conduent_add['purpose']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['purpose']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['purpose']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>

									
									<tr>
										<td rowspan=5 style="background-color:#A9CCE3; font-weight:bold">Throughout the call</td>
										<td colspan=3>Did CSP refer to customer by last name at least once through the call?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points" name="data[csp_customer]" required>
												
												<option acm_val=5 <?php echo $conduent_add['csp_customer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['csp_customer']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['csp_customer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="5" ><textarea name="data[throughout_comment]" class="form-control"><?php echo $conduent_add['throughout_comment'] ?></textarea></td>
									</tr>
									<tr>
										
										<td colspan=3>Did CSP maintain control of call?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[csp_maintain]" required>
												
												<option acm_val=5 <?php echo $conduent_add['csp_maintain']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['csp_maintain']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['csp_maintain']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										
										<td colspan=3>Did CSP follow appropriate Hold/Wait process & avoid DEAD AIR?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[avoid_dead_air]" required>
												
                                                <option acm_val=5 <?php echo $conduent_add['avoid_dead_air']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['avoid_dead_air']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['avoid_dead_air']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										
										<td colspan=3>Did CSP use soft skills?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[soft_skills]" required>
												
                                                <option acm_val=5 <?php echo $conduent_add['soft_skills']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['soft_skills']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['soft_skills']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									
									<tr>
										
										<td colspan=3>Did CSP demonstrate active listening skills?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[listening_skills]" required>
												
                                                <option acm_val=5 <?php echo $conduent_add['listening_skills']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['listening_skills']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['listening_skills']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Product / System Knowledge</td>
										<td colspan=3>Proper use of probing questions?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[questions]" required>
												
												<option acm_val=5 <?php echo $conduent_add['questions']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['questions']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['questions']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="3" ><textarea name="data[product_comment]" class="form-control"><?php echo $conduent_add['product_comment'] ?></textarea></td>
									</tr>

									<tr>
										
										<td colspan=3 >Did CSP use all available systems and tools towards a One Call Resolution?</td>
										<td>10</td>
										<td colspan="2">
											<select class="form-control conduent_points " id="lockheedAF1" name="data[resolution]" required>
												
												<option acm_val=10 <?php echo $conduent_add['resolution']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=10 <?php echo $conduent_add['resolution']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['resolution']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>

									<tr>
										
										<td colspan=3>Did CSP provide complete and accurate information?</td>
										<td>10</td>
										<td colspan="2">
											<select class="form-control conduent_points "  name="data[information]" required>
												
												<option acm_val=10 <?php echo $conduent_add['information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=10 <?php echo $conduent_add['information']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>

									<tr>
									<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Closing</td>
										<td colspan=3 >Did CSP meet documentation expectations?</td>
										<td>10</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[expectations]" required>
												
												<option acm_val=10 <?php echo $conduent_add['expectations']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=10 <?php echo $conduent_add['expectations']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['expectations']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="3" ><textarea name="data[closing_comment]" class="form-control"><?php echo $conduent_add['closing_comment'] ?></textarea></td>
									</tr>

									<tr>
										
										<td colspan=3 >Did CSP select the correct disposition?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points " id="" name="data[disposition]" required>
												
												<option acm_val=5 <?php echo $conduent_add['disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['disposition']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										
										<td colspan=3 >Did the CSP close the call properly?</td>
										<td>5</td>
										<td colspan="2">
											<select class="form-control conduent_points " name="data[properly]" required>
												
												<option acm_val=5 <?php echo $conduent_add['properly']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $conduent_add['properly']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['properly']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									
									</tr>
									
									<tr>
										<td rowspan=8 style="background-color:#A9CCE3; font-weight:bold">Auto Failure</td>
										<td colspan=3 style="color: red;">CSP released account information or made changes to an unverified Cardholder</td>
										<td></td>
										<td colspan="2">
											<select class="form-control conduent_points " id="condtAF1" name="data[cardholder]" required>
												
												<option acm_val=0 <?php echo $conduent_add['cardholder']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=0 <?php echo $conduent_add['cardholder']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['cardholder']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="8" ><textarea name="data[auto_failure_comment]" class="form-control"><?php echo $conduent_add['auto_failure_comment'] ?></textarea></td>
									</tr>

									<tr>
										
										<td colspan=3 style="color: red;">CSP did not resolve the Customer’s issue and did not demonstrate willingness to assist</td>
										<td></td>
										<td colspan="2">
											<select class="form-control conduent_points" id="condtAF2" name="data[assist]" required>
												
												<option acm_val=0 <?php echo $conduent_add['assist']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=0 <?php echo $conduent_add['assist']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['assist']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>

									<tr>
										
										<td colspan=3 style="color: red;">CSP hang up on customer</td>
										<td></td>
										<td colspan="2">
											<select class="form-control conduent_points"  id="condtAF3" name="data[customer]" required>
												
												<option acm_val=0 <?php echo $conduent_add['customer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=0 <?php echo $conduent_add['customer']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['customer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									
									
									<tr>
										
										<td colspan=3 style="color: red;">CSP gives blatant incorrect information to Cardholder.</td>
										<td></td>
										<td colspan="2">
											<select class="form-control conduent_points"  id="condtAF4" name="data[incorrect_information]" required>
												
												<option acm_val=0 <?php echo $conduent_add['incorrect_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=0 <?php echo $conduent_add['incorrect_information']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['incorrect_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									
									<tr>
										
										<td colspan=3 style="color: red;">CSP used inappropriate condescending /argumentative language or tone during the call.</td>
										<td></td>
										<td colspan="2">
											<select class="form-control conduent_points"  id="condtAF5" name="data[condescending]" required>
												
												<option acm_val=0 <?php echo $conduent_add['condescending']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=0 <?php echo $conduent_add['condescending']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['condescending']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										
										<td colspan=3 style="color: red;">CSP did not successfully complete transaction/process.</td>
										<td></td>
										<td colspan="2">
											<select class="form-control conduent_points"  id="condtAF6" name="data[transaction]" required>
												
												<option acm_val=0 <?php echo $conduent_add['transaction']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=0 <?php echo $conduent_add['transaction']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['transaction']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										
										<td colspan=3 style="color: red;">CSP did not leave any memos on accessed account.</td>
										<td></td>
										<td colspan="2">
											<select class="form-control conduent_points"  id="condtAF7" name="data[account]" required>
												
												<option acm_val=0 <?php echo $conduent_add['account']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=0 <?php echo $conduent_add['account']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['account']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										
										<td colspan=3 style="color: red;">Call Avoidance</td>
										<td></td>
										<td colspan="2">
											<select class="form-control conduent_points"  id="condtAF8" name="data[avoidance]" required>
												
												<option acm_val=0 <?php echo $conduent_add['avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=0 <?php echo $conduent_add['avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=0 <?php echo $conduent_add['avoidance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>

									<tr>
										<td colspan="2">Call Summary:</td>
										<td colspan="2"><textarea class="form-control" id="" name="data[call_summary]"><?php echo $conduent_add['call_summary'] ?></textarea></td>
										<td colspan="2">Feedback:</td>
										<td colspan="2"><textarea class="form-control" id="" name="data[feedback]"><?php echo $conduent_add['feedback'] ?></textarea></td>
									</tr>

									<?php if($conduent_id==0){ ?>
									<tr>
										<td colspan=3>Upload Files</td>
										<td colspan=5><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>
										<td colspan=3>Upload Files</td>
										<?php if($conduent_add['attach_file']!=''){ ?>
											<td colspan=5>
												<?php $attach_file = explode(",",$conduent_add['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/conduent/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/conduent/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>


									<?php if($conduent_id!=0){ ?>
										<tr><td colspan=3 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=5><?php echo $conduent_add['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=3 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=5><?php echo $conduent_add['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=3 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=5><?php echo $conduent_add['client_rvw_note'] ?></td></tr>

										<tr><td colspan=3  style="font-size:16px">Your Review</td><td colspan=5><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $conduent_add['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>


									<?php
									if($conduent_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php
										}
									}else{
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
												<tr><td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
									<?php
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
