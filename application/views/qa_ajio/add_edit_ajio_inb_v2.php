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

</style>

<?php if($ajio_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">AJIO [Voice] V2</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($ajio_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($ajio_inb_v2['entry_by']!=''){
												$auditorName = $ajio_inb_v2['auditor_name'];
											}else{
												$auditorName = $ajio_inb_v2['client_name'];
											}
											$auditDate = mysql2mmddyy($ajio_inb_v2['audit_date']);
											$clDate_val = mysqlDt2mmddyy($ajio_inb_v2['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:200px">Call Date/Time:</td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Champ/Agent Name:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $ajio_inb_v2['agent_id'] ?>"><?php echo $ajio_inb_v2['fname']." ".$ajio_inb_v2['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion/BP ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio_inb_v2['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $ajio_inb_v2['tl_id'] ?>"><?php echo $ajio_inb_v2['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio_inb_v2['call_id'] ?>" required ></td>
										<td>Type of Audit:</td>
										<td>
											<select class="form-control" name="data[type_of_audit]" required>
												<option value="<?php echo $ajio_inb_v2['type_of_audit'] ?>"><?php echo $ajio_inb_v2['type_of_audit'] ?></option>
												<option value="">-Select-</option>
												<option value="Detractor Audit">Detractor Audit</option>
												<option value="Passive Audit">Passive Audit</option>
												<option value="Promoter Audit">Promoter Audit</option>
												<option value="High AHT Audit">High AHT Audit</option>
												<option value="Random Audit">Random Audit</option>
												<option value="A2A">A2A</option>
												<option value="Calibration">Calibration</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Predactive CSAT:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $ajio_inb_v2['audit_type'] ?>"><?php echo $ajio_inb_v2['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Hygiene Audit">Hygiene Audit</option>
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
												<option value="<?php echo $ajio_inb_v2['voc'] ?>"><?php echo $ajio_inb_v2['voc'] ?></option>
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
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio_inb_v2['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio_inb_v2['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajio_inb_v2Fatal" style="font-weight:bold" value="<?php echo $ajio_inb_v2['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio_inb_v2['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio_inb_v2['fatal_count'] ?>"></td>
									</tr>
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td colspan=2>Sub Parameter</td>
										<td>Defect</td>
										<td>L1 Reason</td>
										<td>L2 Reason</td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Call Quality & Ettiquettes</td>
										<td colspan=2 style="color:red">Did the champ open the call within 4 seconds and introduce himself properly</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF1" name="data[open_call_within_4sec]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['open_call_within_4sec'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['open_call_within_4sec'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['open_call_within_4sec'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason1]"><?php echo $ajio_inb_v2['l1_reason1'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason1]"><?php echo $ajio_inb_v2['l2_reason1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ address the customer by name</td>
										<td>
											<select class="form-control ajio" name="data[address_customer_by_name]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['address_customer_by_name'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['address_customer_by_name'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason2]"><?php echo $ajio_inb_v2['l1_reason2'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason2]"><?php echo $ajio_inb_v2['l2_reason2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Champ followed the hold procedure as per the SOP</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF2" name="data[follow_hold_procedure]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Unwarranted Hold"?"selected":"";?> value="Unwarranted Hold">Unwarranted Hold</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Dead Air"?"selected":"";?> value="Dead Air">Dead Air</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Uninformed Hold"?"selected":"";?> value="Uninformed Hold">Uninformed Hold</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Uninformed Absence/mute"?"selected":"";?> value="Uninformed Absence/mute">Uninformed Absence/mute</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Hold not refreshed withinh stipulated time"?"selected":"";?> value="Hold not refreshed withinh stipulated time">Hold not refreshed withinh stipulated time</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Hold script/procedure not adhered"?"selected":"";?> value="Hold script/procedure not adhered">Hold script/procedure not adhered</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason3]"><?php echo $ajio_inb_v2['l1_reason3'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason3]"><?php echo $ajio_inb_v2['l2_reason3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ offer further assistance and follow appropriate call closure/supervisor transfer process</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF3" name="data[follow_appropiate_call_closure]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "Failed to offer further assistance"?"selected":"";?> value="Failed to offer further assistance">Failed to offer further assistance</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "Did not pitch for TNPs"?"selected":"";?> value="Did not pitch for TNPs">Did not pitch for TNPs</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "Did not follow call closing script"?"selected":"";?> value="Did not follow call closing script">Did not follow call closing script</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "Did not follow call transfer guidelines"?"selected":"";?> value="Did not follow call transfer guidelines">Did not follow call transfer guidelines</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "TNPS script not adhered/Influenced TNPS"?"selected":"";?> value="TNPS script not adhered/Influenced TNPS">TNPS script not adhered/Influenced TNPS</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "Did not use Genesys end call option"?"selected":"";?> value="Did not use Genesys end call option">Did not use Genesys end call option</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason4]"><?php echo $ajio_inb_v2['l1_reason4'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason4]"><?php echo $ajio_inb_v2['l2_reason4'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#85C1E9; font-weight:bold">Communication Skills</td>
										<td colspan=2>Was the champ polite and used apology and assurance wherever required</td>
										<td>
											<select class="form-control ajio" name="data[polite_use_appology]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['polite_use_appology'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['polite_use_appology'] == "Apology used but misplaced"?"selected":"";?> value="Apology used but misplaced">Apology used but misplaced</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['polite_use_appology'] == "Did not provide effective assurance"?"selected":"";?> value="Did not provide effective assurance">Did not provide effective assurance</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['polite_use_appology'] == "Did not acknowledge/apologize when required"?"selected":"";?> value="Did not acknowledge/apologize when required">Did not acknowledge/apologize when required</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['polite_use_appology'] == "Lack of pleasantries"?"selected":"";?> value="Lack of pleasantries">Lack of pleasantries</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason5]"><?php echo $ajio_inb_v2['l1_reason5'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason5]"><?php echo $ajio_inb_v2['l2_reason5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the champ able to comprehend and paraphrase the customer's concern</td>
										<td>
											<select class="form-control ajio" name="data[comprehend_customer_concern]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['comprehend_customer_concern'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['comprehend_customer_concern'] == "Asked unnecessary/irrelevant questions"?"selected":"";?> value="Asked unnecessary/irrelevant questions">Asked unnecessary/irrelevant questions</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['comprehend_customer_concern'] == "Asked details already available"?"selected":"";?> value="Asked details already available">Asked details already available</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['comprehend_customer_concern'] == "Unable to comprehend"?"selected":"";?> value="Unable to comprehend">Unable to comprehend</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['comprehend_customer_concern'] == "Failed to paraphrase to ensure understanding"?"selected":"";?> value="Failed to paraphrase to ensure understanding">Failed to paraphrase to ensure understanding</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason6]"><?php echo $ajio_inb_v2['l1_reason6'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason6]"><?php echo $ajio_inb_v2['l2_reason6'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ display active listening skills without making the customer repeat</td>
										<td>
											<select class="form-control ajio" name="data[display_active_listening_skill]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['display_active_listening_skill'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['display_active_listening_skill'] == "Champ made the customer repeat"?"selected":"";?> value="Champ made the customer repeat">Champ made the customer repeat</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['display_active_listening_skill'] == "Did not listen actively impacting the call"?"selected":"";?> value="Did not listen actively impacting the call">Did not listen actively impacting the call</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason7]"><?php echo $ajio_inb_v2['l1_reason7'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason7]"><?php echo $ajio_inb_v2['l2_reason7'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the champ able to handle objections effectively and offer rebuttals wherever required</td>
										<td>
											<select class="form-control ajio" name="data[handle_objection_effectively]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['handle_objection_effectively'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['handle_objection_effectively'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['handle_objection_effectively'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason8]"><?php echo $ajio_inb_v2['l1_reason8'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason8]"><?php echo $ajio_inb_v2['l2_reason8'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was champ able to express/articulate himself and seamlessly converse with the customer</td>
										<td>
											<select class="form-control ajio" name="data[express_himself_with_customer]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['express_himself_with_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['express_himself_with_customer'] == "Champ was struggling to express himself"?"selected":"";?> value="Champ was struggling to express himself">Champ was struggling to express himself</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['express_himself_with_customer'] == "Champ swtiched language to express himself"?"selected":"";?> value="Champ swtiched language to express himself">Champ swtiched language to express himself</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['express_himself_with_customer'] == "Customer expressed difficulty in understanding the champ"?"selected":"";?> value="Customer expressed difficulty in understanding the champ">Customer expressed difficulty in understanding the champ</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason9]"><?php echo $ajio_inb_v2['l1_reason9'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason9]"><?php echo $ajio_inb_v2['l2_reason9'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage</td>
										<td colspan=2>Did the champ refer to all releavnt articles/T2Rs correctly</td>
										<td>
											<select class="form-control ajio" name="data[refer_all_releavnt_article]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['refer_all_releavnt_article'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['refer_all_releavnt_article'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason10]"><?php echo $ajio_inb_v2['l1_reason10'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason10]"><?php echo $ajio_inb_v2['l2_reason10'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution</td>
										<td>
											<select class="form-control ajio" name="data[refer_different_application]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['refer_different_application'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['refer_different_application'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason11]"><?php echo $ajio_inb_v2['l1_reason11'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason11]"><?php echo $ajio_inb_v2['l2_reason11'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Call/Interaction was authenticated wherever required</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF4" name="data[call_was_authenticated]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['call_was_authenticated'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['call_was_authenticated'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['call_was_authenticated'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['call_was_authenticated'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason12]"><?php echo $ajio_inb_v2['l1_reason12'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason12]"><?php echo $ajio_inb_v2['l2_reason12'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the champ able to effectively navigate through and toggle between different tools/aids to wrap up the call in a timely manner</td>
										<td>
											<select class="form-control ajio" name="data[effectively_navigate_through]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['effectively_navigate_through'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['effectively_navigate_through'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason13]"><?php echo $ajio_inb_v2['l1_reason13'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason13]"><?php echo $ajio_inb_v2['l2_reason13'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td colspan=2 style="color:red">Champ executed all necessary actions to ensure issue resolution</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF5" name="data[executed_all_necessary]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['executed_all_necessary'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
										<!-- 		<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['executed_all_necessary'] == "C&R raised when not required"?"selected":"";?> value="C&R raised when not required">C&R raised when not required</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['executed_all_necessary'] == "C&R not raised when required"?"selected":"";?> value="C&R not raised when required">C&R not raised when required</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['executed_all_necessary'] == "Wrong C&R raised"?"selected":"";?> value="Wrong C&R raised">Wrong C&R raised</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['executed_all_necessary'] == "C&R raised without images/appropriate details"?"selected":"";?> value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['executed_all_necessary'] == "Action not taken"?"selected":"";?> value="Action not taken">Action not taken</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['executed_all_necessary'] == "Unnecessary redirection"?"selected":"";?> value="Unnecessary redirection">Unnecessary redirection</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['executed_all_necessary'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>
											<!--<textarea class="form-control" name="data[l1_reason14]"><?php //echo $ajio_inb_v2['l1_reason14'] ?></textarea>-->
											<select class="form-control" name="data[l1_reason14]" >
												<option value=""></option>
												<option <?php echo $ajio_inb_v2['l1_reason14'] == "C&R raised when not required"?"selected":"";?> value="C&R raised when not required">C&R raised when not required</option>
												<option <?php echo $ajio_inb_v2['l1_reason14'] == "C&R not raised when required"?"selected":"";?> value="C&R not raised when required">C&R not raised when required</option>
												<option <?php echo $ajio_inb_v2['l1_reason14'] == "Wrong C&R raised"?"selected":"";?> value="Wrong C&R raised">Wrong C&R raised</option>
												<option <?php echo $ajio_inb_v2['l1_reason14'] == "C&R raised without images/appropriate details"?"selected":"";?> value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>
												<option <?php echo $ajio_inb_v2['l1_reason14'] == "Action not taken & Unnecessary redirection"?"selected":"";?> value="Action not taken & Unnecessary redirection">Action not taken & Unnecessary redirection</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason14]"><?php echo $ajio_inb_v2['l2_reason14'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer</td>
										<td>
											<select class="form-control ajio" id="ajioAF8" name="data[queries_answered_properly]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['queries_answered_properly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=10 <?php //echo $ajio_inb_v2['queries_answered_properly'] == "Incorrect information Shared"?"selected":"";?> value="Incorrect information Shared">Incorrect information Shared</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio_inb_v2['queries_answered_properly'] == "Incomplete information Shared"?"selected":"";?> value="Incomplete information Shared">Incomplete information Shared</option> -->
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['queries_answered_properly'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>
											<!--<textarea class="form-control" name="data[l1_reason15]"><?php echo $ajio_inb_v2['l1_reason15'] ?></textarea>-->
											<select class="form-control" name="data[l1_reason15]" >
												<option value=""></option>
												<option <?php echo $ajio_inb_v2['l1_reason15'] == "Incorrect information Shared"?"selected":"";?> value="Incorrect information Shared">Incorrect information Shared</option>
												<option <?php echo $ajio_inb_v2['l1_reason15'] == "Incomplete information Shared"?"selected":"";?> value="Incomplete information Shared">Incomplete information Shared</option>
												<option <?php echo $ajio_inb_v2['l1_reason15'] == "Wrong action taken & No action taken"?"selected":"";?> value="Wrong action taken & No action taken">Wrong action taken & No action taken</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason15]"><?php echo $ajio_inb_v2['l2_reason15'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ document the case correctly and adhered to tagging guidelines</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF6" name="data[document_the_case_correctly]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['document_the_case_correctly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['document_the_case_correctly'] == "CAM rule not adhered to"?"selected":"";?> value="CAM rule not adhered to">CAM rule not adhered to</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['document_the_case_correctly'] == "Documented on incorrect account"?"selected":"";?> value="Documented on incorrect account">Documented on incorrect account</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['document_the_case_correctly'] == "All queries not documented"?"selected":"";?> value="All queries not documented">All queries not documented</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['document_the_case_correctly'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason16]"><?php echo $ajio_inb_v2['l1_reason16'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason16]"><?php echo $ajio_inb_v2['l2_reason16'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
										<td colspan=2 style="color:red">As per AJIO ZTP guidelines</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF7" name="data[ztp_guidelines]" required>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_inb_v2['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_inb_v2['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l1_reason17]"><?php echo $ajio_inb_v2['l1_reason17'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason17]"><?php echo $ajio_inb_v2['l2_reason17'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Synopsis:</td>
										<td colspan=3><textarea class="form-control" name="data[call_synopsis]"><?php echo $ajio_inb_v2['call_synopsis'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Observation:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ajio_inb_v2['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $ajio_inb_v2['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($ajio_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($ajio_inb_v2['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio_inb_v2['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($ajio_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $ajio_inb_v2['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $ajio_inb_v2['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $ajio_inb_v2['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $ajio_inb_v2['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($ajio_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($ajio_inb_v2['entry_date'],72) == true){ ?>
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
