<style>

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
	background-color:#85C1E9;
}

.eml1{
	font-weight:bold;
	background-color:#76D7C4;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
		}
	</style>
<?php } ?>

<div class="wrap">
	<section class="app-content">


		<div class="row">
		<form id="form_mgnt_user" method="POST" action="" enctype="multipart/form-data">

			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader" style="font-size:30px">JURY'S INN [Reservation CIS Evaluation]
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
										</td>
									</tr>
									
									<tr>
										<td>QA Name:</td>
										<?php if($jurys_inn_feedback['entry_by']!=''){
												$auditorName = $jurys_inn_feedback['auditor_name'];
											}else{
												$auditorName = $jurys_inn_feedback['client_name'];
										} 
										// echo"<pre>";
										// print_r($jurys_inn_feedback);
										// echo"</pre>";
										$tl_id = $jurys_inn_feedback['tl_id'];
										$tl_name = $jurys_inn_feedback['tl_name'];
										?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($jurys_inn_feedback['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($jurys_inn_feedback['call_date']); ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $jurys_inn_feedback['agent_id'] ?>"><?php echo $jurys_inn_feedback['fname']." ".$jurys_inn_feedback['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $jurys_inn_feedback['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td style="width:250px">
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="tl_id" value="<?php echo $tl_id ?>" required>
										</td>
									</tr>
									<tr>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" value="<?php echo $jurys_inn_feedback['campaign'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $jurys_inn_feedback['call_duration'] ?>" required></td>
										<td>Reservation Number:</td>
										<td><input type="text" class="form-control" id="reservation_no" name="reservation_no" value="<?php echo $jurys_inn_feedback['reservation_no'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="<?php echo $jurys_inn_feedback['audit_type'] ?>"><?php echo $jurys_inn_feedback['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Client Escalation">Client Escalation</option>
												<option value="Wow Call">Wow Call</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option <?php echo $jurys_inn_feedback['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $jurys_inn_feedback['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="<?php echo $jurys_inn_feedback['voc'] ?>"><?php echo $jurys_inn_feedback['voc'] ?></option>
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
										<!-- <td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="jurys_inn_possible_score" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $jurys_inn_feedback['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="jurys_inn_earned_score" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $jurys_inn_feedback['earned_score'] ?>"></td> -->
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="jurys_inn_overall_score" name="overall_score" class="form-control" style="font-weight:bold" value="<?php echo $jurys_inn_feedback['overall_score'] ?>"></td>
									</tr>
									<tr>
										<?php if($jurys_inn_feedback['earned_score']!='0'){ 
												$autoPF='Pass';
												$style='style="color:green"';
											  }else{
												$autoPF='Fail';
												$style='style="color:red"';
											  }
										?>
										<td colspan=5 style="font-weight:bold; text-align:right">Auto Pass/Fail:</td>
										<td><input type="text" style="font-weight:bold; font-size:16px;" readonly <?php echo $style ?> class="form-control" id="jurysinn_PF" value="<?php echo $autoPF ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td >PARAMETER</td>
										<td >SUB-PARAMETER</td>
										<td>STATUS</td>
										<td>POINTS</td>
										<td >COMMENT</td>
										<td >CRITICALITIES</td>
									</tr>
									<tr>
										<td class="eml" rowspan=5>Greet & Engage</td>
										<td class="eml1" >Did the agent Greet the Customer appropriately?</td>
										<td>
											<select class="form-control jurry_points customer" id="greet_customer" name="greet_customer" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_customer'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['greet_customer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="greet1_comm" value="<?php echo $jurys_inn_feedback['greet1_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent offer his/her name?</td>
										<td>
											<select class="form-control jurry_points customer" id="greet_name" name="greet_name" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_name'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_name'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['greet_name'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="greet2_comm" value="<?php echo $jurys_inn_feedback['greet2_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent ascertain the customer name and use conversationally?</td>
										<td>
											<select class="form-control jurry_points customer" id="greet_conversation" name="greet_conversation" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_conversation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_conversation'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['greet_conversation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="greet3_comm" value="<?php echo $jurys_inn_feedback['greet3_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent ask an Open Question?</td>
										<td>
											<select class="form-control jurry_points customer" id="greet_question" name="greet_question" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_question'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_question'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['greet_question'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="greet4_comm" value="<?php echo $jurys_inn_feedback['greet4_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent utilise all resources available, such as whisper and iPath display?</td>
										<td>
											<select class="form-control jurry_points customer" id="greet_utilise" name="greet_utilise" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_utilise'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['greet_utilise'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['greet_utilise'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="greet5_comm" value="<?php echo $jurys_inn_feedback['greet5_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml" rowspan='4'>Qualification</td>
										<td class="eml1" >Did the agent determine if the call was for business or leisure and if rate was applicable?</td>
										<td>
											<select class="form-control jurry_points business" id="qualifi_determine" name="qualifi_determine" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['qualifi_determine'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['qualifi_determine'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['qualifi_determine'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="qualifi1_comm" value="<?php echo $jurys_inn_feedback['qualifi1_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent reconfirm to caller when the customer wants to stay?</td>
										<td>
											<select class="form-control jurry_points business" id="qualifi_reconfirm" name="qualifi_reconfirm" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['qualifi_reconfirm'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['qualifi_reconfirm'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['qualifi_reconfirm'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="qualifi2_comm" value="<?php echo $jurys_inn_feedback['qualifi2_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent reconfirm to caller where the customer wants to stay?</td>
										<td>
											<select class="form-control jurry_points business" id="qualifi_customer" name="qualifi_customer" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['qualifi_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['qualifi_customer'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['qualifi_customer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="qualifi3_comm" value="<?php echo $jurys_inn_feedback['qualifi3_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent ask and reconfirm the number of rooms and guests?</td>
										<td>
											<select class="form-control jurry_points business" id="qualifi_guest" name="qualifi_guest" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['qualifi_guest'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['qualifi_guest'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['qualifi_guest'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="qualifi4_comm" value="<?php echo $jurys_inn_feedback['qualifi4_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Recognise</td>
										<td class="eml1" >Did the agent determine if the guest has stayed with us before?</td>
										<td>
											<select class="form-control jurry_points business" id="recognise_agent" name="recognise_agent" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['recognise_agent'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['recognise_agent'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['recognise_agent'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="recognise1_comm" value="<?php echo $jurys_inn_feedback['recognise1_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent take relevant caller and profile information</td>
										<td>
											<select class="form-control jurry_points business" id="recognise_caller" name="recognise_caller" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['recognise_caller'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['recognise_caller'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['recognise_caller'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="recognise2_comm" value="<?php echo $jurys_inn_feedback['recognise2_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" style="color:red" >Did the agent conform to GDPR requirements during the call?</td>
										<td>
											<select class="form-control jurry_points compliance1" id="recognise_gdpr" name="recognise_gdpr" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['recognise_gdpr'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['recognise_gdpr'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['recognise_gdpr'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="recognise3_comm" value="<?php echo $jurys_inn_feedback['recognise3_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#AAF0D1">Compliance</td>
									</tr>
									<tr>
										<td class="eml" rowspan=5>Recommend</td>
										<td class="eml1" >Did the agent determine if the guest (not caller) was a Jurys Rewards member?</td>
										<td>
											<select class="form-control jurry_points business" id="recomend_guest" name="recomend_guest" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['recomend_guest'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['recomend_guest'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['recomend_guest'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control"name="recomend1_comm" value="<?php echo $jurys_inn_feedback['recomend1_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent recommend the benefits of the Jurys Rewards programme?</td>
										<td>
											<select class="form-control jurry_points business" id="recomend_benefit" name="recomend_benefit" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['recomend_benefit'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['recomend_benefit'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['recomend_benefit'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="recomend2_comm" value="<?php echo $jurys_inn_feedback['recomend2_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent offer to enrol the guest on Jurys Rewards?</td>
										<td>
											<select class="form-control jurry_points business" id="recomend_offer" name="recomend_offer" required>
												<option ji_val=1 <?php echo $jurys_inn_feedback['recomend_offer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['recomend_offer'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['recomend_offer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="recomend3_comm" value="<?php echo $jurys_inn_feedback['recomend3_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent upsell the room type and offer the benefits?</td>
										<td>
											<select class="form-control jurry_points business" id="recomend_upsell" name="recomend_upsell" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['recomend_upsell'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['recomend_upsell'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['recomend_upsell'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="recomend4_comm" value="<?php echo $jurys_inn_feedback['recomend4_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent offer Room Only and Bed & Breakfast?</td>
										<td>
											<select class="form-control jurry_points business" id="recomend_room" name="recomend_room" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['recomend_room'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['recomend_room'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['recomend_room'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="recomend5_comm" value="<?php echo $jurys_inn_feedback['recomend5_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Overcome Objections</td>
										<td class="eml1" >Did the agent offer alternates positively</td>
										<td>
											<select class="form-control jurry_points business" id="overcome_positive" name="overcome_positive" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['overcome_positive'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['overcome_positive'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['overcome_positive'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="overcome1_comm" value="<?php echo $jurys_inn_feedback['overcome1_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" style="color:red" >Did the agent present terms and conditions positively at the time of quoting?</td>
										<td>
											<select class="form-control jurry_points compliance1" id="overcome_terms" name="overcome_terms" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['overcome_terms'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['overcome_terms'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['overcome_terms'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="overcome2_comm" value="<?php echo $jurys_inn_feedback['overcome2_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#AAF0D1">Compliance</td>
									</tr>
									<!-- <tr>
										<td class="eml1" colspan=2>Did the agent offer the caller to contact the hotel for the correct reason? </td>
										<td>
											<select class="form-control jurry_points compliance" id="correct_reason" name="correct_reason" required>
												<option value="">-Select-</option>
												<option ji_val=2 <?php //echo $jurys_inn_feedback['correct_reason'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php //echo $jurys_inn_feedback['correct_reason'] == "Yes"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php //echo $jurys_inn_feedback['correct_reason'] == "Yes"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="correct_reason_comm" value="<?php //echo $jurys_inn_feedback['correct_reason_comm'] == "Yes"?"selected":"";?>"></td>
									</tr> -->
									<tr>
										<td class="eml1" >Did the agent offer the caller to contact the hotel for the correct reason? </td>
										<!-- <td style="display:none" class="weightage_value">1</td> -->
										<td>
											<select class="form-control jurry_points compliance1" id="correct_reason" name="correct_reason" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['correct_reason'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['correct_reason'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['correct_reason'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" value="<?php echo $jurys_inn_feedback['correct_reason_comm'] ?>" required></td>
										<td style="font-weight:bold; background-color:#AAF0D1">Compliance</td>
									</tr>
									<tr>
										<td class="eml">Close the Sale</td>
										<td class="eml1" >Did the agent ask if the caller wants to proceed with the booking?</td>
										<td>
											<select class="form-control jurry_points business" id="sale_business" name="sale_business" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['sale_business'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['sale_business'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['sale_business'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="sale1_comm" value="<?php echo $jurys_inn_feedback['sale1_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml" rowspan=6>Appropriate Closure</td>
										<td class="eml1" style="color:red" >Did the agent reconfirm all booking details including reservation number and cancellation policy</td>
										<td>
											<select class="form-control jurry_points compliance1" id="closure_booking" name="closure_booking" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['closure_booking'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['closure_booking'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['closure_booking'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="closure1_comm" value="<?php echo $jurys_inn_feedback['closure1_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#AAF0D1">Compliance</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent follow the correct SOP?</td>
										<td>
											<select class="form-control jurry_points compliance1" id="follow_SOP" name="follow_SOP" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['follow_SOP'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['follow_SOP'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['follow_SOP'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="closure5_comm" value="<?php echo $jurys_inn_feedback['closure5_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#AAF0D1">Compliance</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent offer to send a confirmation email?</td>
										<td>
											<select class="form-control jurry_points business" id="closure_email" name="closure_email" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['closure_email'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['closure_email'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['closure_email'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="closure2_comm" value="<?php echo $jurys_inn_feedback['closure2_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent advise that directions and parking information are on the confirmation?</td>
										<td>
											<select class="form-control jurry_points business" id="closure_advise" name="closure_advise" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['closure_advise'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['closure_advise'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['closure_advise'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="closure3_comm" value="<?php echo $jurys_inn_feedback['closure3_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent ask if there was anything else?</td>
										<td>
											<select class="form-control jurry_points business" id="closure_ask" name="closure_ask" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $jurys_inn_feedback['closure_ask'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['closure_ask'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['closure_ask'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="closure4_comm" value="<?php echo $jurys_inn_feedback['closure4_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
										<!-- Newly Added-->
									<tr>
										<td class="eml1" >	Did the agent apply the correct call tag?</td>
										<td>
											<select class="form-control jurry_points business" id="correct_call" name="correct_call" required>
												<option ji_val=2 <?php echo $jurys_inn_feedback['correct_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $jurys_inn_feedback['correct_call'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['correct_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td ><input type="text" class="form-control" name="cmt_comm" value="<?php echo $jurys_inn_feedback['cmt_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#C0C0C0">Business</td>
									</tr>
								
									<tr>
										<td class="eml" rowspan=8>Soft skills</td>
										<td class="eml1" >Did the agent avoid long silences and Long-hold during the call?</td>
										<td>
											<select class="form-control jurry_points customer" id="ss_avoid" name="ss_avoid" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_avoid'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_avoid'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['ss_avoid'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="ss1_comm" value="<?php echo $jurys_inn_feedback['ss1_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent display a professional manner throughout the call?</td>
										<td>
											<select class="form-control jurry_points customer" id="ss_display" name="ss_display" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_display'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_display'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['ss_display'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="ss2_comm" value="<?php echo $jurys_inn_feedback['ss2_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent pro-actively volunteer additional info throughout the call?</td>
										<td>
											<select class="form-control jurry_points customer" id="ss_volunteer" name="ss_volunteer" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_volunteer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_volunteer'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['ss_volunteer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="ss3_comm" value="<?php echo $jurys_inn_feedback['ss3_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent sound clear and confident throughout the call?</td>
										<td>
											<select class="form-control jurry_points customer" id="ss_sound" name="ss_sound" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_sound'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_sound'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['ss_sound'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="ss4_comm" value="<?php echo $jurys_inn_feedback['ss4_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent refrain from using jargon throughout the call?</td>
										<td>
											<select class="form-control jurry_points customer" id="ss_refrain" name="ss_refrain" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_refrain'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_refrain'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['ss_refrain'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="ss5_comm" value="<?php echo $jurys_inn_feedback['ss5_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent sound friendly, polite and welcoming?</td>
										<td>
											<select class="form-control jurry_points customer" id="ss_welcome" name="ss_welcome" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_welcome'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_welcome'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['ss_welcome'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="ss6_comm" value="<?php echo $jurys_inn_feedback['ss6_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent use effective questioning skills?</td>
										<td>
											<select class="form-control jurry_points customer" id="ss_question" name="ss_question" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_question'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_question'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['ss_question'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="ss7_comm" value="<?php echo $jurys_inn_feedback['ss7_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr>
										<td class="eml1" >Did the agent demonstrate active listening?</td>
										<td>
											<select class="form-control jurry_points customer" id="ss_demonstrate" name="ss_demonstrate" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_demonstrate'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $jurys_inn_feedback['ss_demonstrate'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $jurys_inn_feedback['ss_demonstrate'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td ><input type="text" class="form-control" name="ss8_comm" value="<?php echo $jurys_inn_feedback['ss8_comm'] ?>"></td>
										<td style="font-weight:bold; background-color:#FAEBD7">Customer</td>
									</tr>
									<tr style="background-color:#AEB6BF">
										<td style="">YES Count</td>
										<td><input type="text" readonly class="form-control" style="background-color:#B3B6B7" id="pass_count" name="pass_count" value="<?php echo $jurys_inn_feedback['pass_count'] ?>"></td>
										<td style="">NO Count</td>
										<td><input type="text" readonly class="form-control" style="background-color:#B3B6B7" id="fail_count" name="fail_count" value="<?php echo $jurys_inn_feedback['fail_count'] ?>"></td>
										<td style="">N/A Count</td>
										<td><input type="text" readonly class="form-control" style="background-color:#B3B6B7" id="na_count" name="na_count" value="<?php echo $jurys_inn_feedback['na_count'] ?>"></td>
									</tr>
									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned"></td><td>Earned:</td><td id="busiJiCisEarned"></td><td>Earned:</td><td id="complJiCisEarned"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible"></td><td>Possible:</td><td id="busiJiCisPossible"></td><td>Possible:</td><td id="complJiCisPossible"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="customer_score"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="business_score"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="compliance_score"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" id="call_summary" name="call_summary"><?php echo $jurys_inn_feedback['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" id="feedback" name="feedback"><?php echo $jurys_inn_feedback['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($jurys_inn_feedback['attach_file']!=''){ ?>
									<tr>
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$jurys_inn_feedback['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_jurys_inn/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_jurys_inn/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php }
									
									if($jurys_inn_feedback['entry_by']==get_user_id()){ ?>
										<tr>
											<td colspan=2>Edit Upload</td><td colspan=4><input type="file" multiple class="form-control1" id="fileuploadbasic" name="attach_file[]"></td>
										</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Agent Feedback Acceptance:</td> <td colspan="5" style="text-align:left"><?php echo $jurys_inn_feedback['agnt_fd_acpt']; ?></td></tr>
									<tr><td style="font-size:16px">Agent Review:</td> <td colspan="5" style="text-align:left"><?php echo $jurys_inn_feedback['agent_rvw_note']; ?></td></tr>
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $jurys_inn_feedback['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $jurys_inn_feedback['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td colspan="2"  style="font-size:16px">Client/Manager Reviews</td>
										<td colspan="4"><textarea class="form-control1" style="width:100%" name="note" placeholder="Please Write Reviews Here..." required></textarea></td>
									</tr>
									
									<?php if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
									if(is_available_qa_feedback($jurys_inn_feedback['entry_date'],72) == true){ ?>
										<tr>
											<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
										</tr>
									<?php } 
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>	
			</div>

		</form>	
		</div>

	</section>
</div>
