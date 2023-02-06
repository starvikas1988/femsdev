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

<?php if($pilgrim_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">Pilgrim</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($pilgrim_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($pilgrim['entry_by']!=''){
												$auditorName = $pilgrim['auditor_name'];
											}else{
												$auditorName = $pilgrim['client_name'];
											}
											$auditDate = mysql2mmddyy($pilgrim['audit_date']);
											$clDate_val = mysql2mmddyy($pilgrim['call_date']);
										}
									?>
									<tr>
										<td style="width:150px">Auditor Name:</td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td style="width:150px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<?php 
												if($pilgrim['agent_id']!=''){
													?>
													<option value="<?php echo $pilgrim['agent_id'] ?>"><?php echo $pilgrim['fname']." ".$pilgrim['lname']." - ".$pilgrim['fusion_id'] ?></option>
													<?php 
												}
												?>
												
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']." - ".$row['fusion_id']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Process:</td>
										<td><input type="text" class="form-control" id="campaign" value="<?php echo $pilgrim['process'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $pilgrim['tl_id'] ?>"><?php echo $pilgrim['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Site/Location:</td>
										<td><input type="text" readonly class="form-control" id="office_id" value="<?php echo $pilgrim['office_id'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $pilgrim['call_duration']; ?>" required ></td>
										<td>File No:</td>
										<td><input type="text" class="form-control" id="" name="data[file_no]" value="<?php echo $pilgrim['file_no']; ?>" required ></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required >
												<option value="">-Select-</option>
												<option <?php echo $pilgrim['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $pilgrim['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $pilgrim['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $pilgrim['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $pilgrim['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
                        <option value="WOW Call">WOW Call</option>
												<?php if(get_login_type()!="client"){ ?>
													<option <?php echo $pilgrim['audit_type']=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
													<option <?php echo $pilgrim['audit_type']=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
												<?php } ?>
											</select>
										</td>
										<td>Auditor Type</td>
										<td>
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
												<option <?php echo $pilgrim['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $pilgrim['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $pilgrim['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $pilgrim['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $pilgrim['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
                  <tr>
                    <td>Earned Score</td>
                    <td><input type="text" class="form-control" readonly id="pilgrim_earnedScore" name="data[earned_score]" value="<?= $pilgrim['earned_score']?>"/></td>
                    <td>Possible Score</td>
                    <td><input type="text" class="form-control" readonly id="pilgrim_possibleScore" name="data[possible_score]" value="<?= $pilgrim['possible_score']?>"/></td>
                    <td>Overall Score</td>
                    <td><input type="text" class="form-control" readonly id="pilgrim_overallScore" name="data[overall_score]" value="<?= $pilgrim['overall_score']?>"/></td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-striped skt-table" style="width:100%;">
                <tbody>
									<tr style="height:25px; font-weight:bold">
										<td>Parameter</td>
										<td>Weightage</td>
                    <td>Marking Status</td>
                    <td colspan="2">Comments/Notes</td>
                    <td>Critical Accuracy</td>
									</tr>
									<tr>
                    <td class="eml">Did the agent open the call within 5 seconds?</td>
                    <td>5</td>
                    <td>
                      <select class="form-control amd_pilgrim_point customer" id="open_call_within_5sec" name="data[open_call_within_5sec]" required>
                        <option amd_val=5 amd_max=5 <?= ($pilgrim['open_call_within_5sec']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=5 <?= ($pilgrim['open_call_within_5sec']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=5 amd_max=5 <?= ($pilgrim['open_call_within_5sec']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt1]" class="form-control" value="<?= $pilgrim['cmt1']?>"/>
                    </td>
                    <td colspan="">Customer Critical</td>
                  </tr>
									<tr>
                    <td class="eml">Did the agent give the proper introduction and include their name?</td>
                    <td>5</td>
                    <td>
                      <select class="form-control amd_pilgrim_point business" id="proper_introduction" name="data[proper_introduction]" required>
                        <option amd_val=5 amd_max=5 <?= ($pilgrim['proper_introduction']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=5 <?= ($pilgrim['proper_introduction']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=5 amd_max=5 <?= ($pilgrim['proper_introduction']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt2]" class="form-control" value="<?= $pilgrim['cmt2']?>"/>
                    </td>
                    <td colspan="">Business Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Did the agent explain the offer and/or products?</td>
                    <td>5</td>
                    <td>
                      <select class="form-control amd_pilgrim_point business" id="explain_offer" name="data[explain_offer]" required>
                        <option amd_val=5 amd_max=5 <?= ($pilgrim['explain_offer']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=5 <?= ($pilgrim['explain_offer']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=5 amd_max=5 <?= ($pilgrim['explain_offer']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt3]" class="form-control" value="<?= $pilgrim['cmt3']?>"/>
                    </td>
                    <td colspan="">Business Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Did the agent give customer proper responses?</td>
                    <td>5</td>
                    <td>
                      <select class="form-control amd_pilgrim_point customer" id="proper_response" name="data[proper_response]" required>
                        <option amd_val=5 amd_max=5 <?= ($pilgrim['proper_response']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=5 <?= ($pilgrim['proper_response']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=5 amd_max=5 <?= ($pilgrim['proper_response']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt4]" class="form-control" value="<?= $pilgrim['cmt4']?>"/>
                    </td>
                    <td colspan="">Customer Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Did the agent correctly probe?</td>
                    <td>6</td>
                    <td>
                      <select class="form-control amd_pilgrim_point business" id="correct_probe" name="data[correct_probe]" required>
                        <option amd_val=6 amd_max=6 <?= ($pilgrim['correct_probe']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=6 <?= ($pilgrim['correct_probe']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=6 amd_max=6 <?= ($pilgrim['correct_probe']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt5]" class="form-control" value="<?= $pilgrim['cmt5']?>"/>
                    </td>
                    <td colspan="">Business Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Did the agent disposition the call properly?</td>
                    <td>8</td>
                    <td>
                      <select class="form-control amd_pilgrim_point business" id="proper_disposition" name="data[proper_disposition]" required>
                        <option amd_val=8 amd_max=8 <?= ($pilgrim['proper_disposition']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=8 <?= ($pilgrim['proper_disposition']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=8 amd_max=8 <?= ($pilgrim['proper_disposition']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt6]" class="form-control" value="<?= $pilgrim['cmt6']?>"/>
                    </td>
                     <td colspan="">Business Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Was the agent polite & courteous?</td>
                    <td>10</td>
                    <td>
                      <select class="form-control amd_pilgrim_point customer" id = "polite_agent" name="data[polite_agent]" required>
                        <option amd_val=10 amd_max=10 <?= ($pilgrim['polite_agent']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=10 <?= ($pilgrim['polite_agent']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=10 amd_max=10 <?= ($pilgrim['polite_agent']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt7]" class="form-control" value="<?= $pilgrim['cmt7']?>"/>
                    </td>
                    <td colspan="">Customer Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Was the agent ready for the call (minimal dead air)?</td>
                    <td>8</td>
                    <td>
                      <select class="form-control amd_pilgrim_point business" id="minimal_dead_air" name="data[minimal_dead_air]" required>
                        <option amd_val=8 amd_max=8 <?= ($pilgrim['minimal_dead_air']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=8 <?= ($pilgrim['minimal_dead_air']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=8 amd_max=8 <?= ($pilgrim['minimal_dead_air']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt8]" class="form-control" value="<?= $pilgrim['cmt8']?>"/>
                    </td>
                    <td colspan="">Business Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Did the agent show energy, empathy and enthusiasm?</td>
                    <td>8</td>
                    <td>
                      <select class="form-control amd_pilgrim_point customer" id="energy" name="data[energy]" required>
                        <option amd_val=8 amd_max=8 <?= ($pilgrim['energy']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=8 <?= ($pilgrim['energy']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=8 amd_max=8 <?= ($pilgrim['energy']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt9]" class="form-control" value="<?= $pilgrim['cmt9']?>"/>
                    </td>
                    <td colspan="">Customer Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Did the agent use appropriate tone, pacing, grammar & pronunciation?</td>
                    <td>10</td>
                    <td>
                      <select class="form-control amd_pilgrim_point customer" id="tone_pacing" name="data[tone_pacing]" required>
                        <option amd_val=10 amd_max=10 <?= ($pilgrim['tone_pacing']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=10 <?= ($pilgrim['tone_pacing']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=10 amd_max=10 <?= ($pilgrim['tone_pacing']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt10]" class="form-control" value="<?= $pilgrim['cmt10']?>"/>
                    </td>
                    <td colspan="">Customer Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Did the agent show accurate and complete grasp of information?</td>
                    <td>8</td>
                    <td>
                      <select class="form-control amd_pilgrim_point business" id="acc_comp_info" name="data[acc_comp_info]" required>
                        <option amd_val=8 amd_max=8 <?= ($pilgrim['acc_comp_info']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=8 <?= ($pilgrim['acc_comp_info']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=8 amd_max=8 <?= ($pilgrim['acc_comp_info']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt11]" class="form-control" value="<?= $pilgrim['cmt11']?>"/>
                    </td>
                    <td colspan="">Business Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Did the agent set up Gold Card correctly-ideology #, acct #, caller’s name in the notes, give caller
                      acct # and code (no dash), & provide the phone number to access the lines (1-800-386-1000</td>
                    <td>10</td>
                    <td>
                      <select class="form-control amd_pilgrim_point business" id="setup_gold_card" name="data[setup_gold_card]" required>
                        <option amd_val=10 amd_max=10 <?= ($pilgrim['setup_gold_card']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=10 <?= ($pilgrim['setup_gold_card']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=10 amd_max=10 <?= ($pilgrim['setup_gold_card']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt12]" class="form-control" value="<?= $pilgrim['cmt12']?>"/>
                    </td>
                    <td colspan="">Business Critical</td>
                  </tr>
                  <tr>
                    <td class="eml">Did the agent properly disengage disruptive/prank caller (this is the customer service line, we must
                      remain professional. For chat services please dial 1-800-Free Sex)
                      Properly document account if call back is necessary with call back #, name, & reason</td>
                    <td>10</td>
                    <td>
                      <select class="form-control amd_pilgrim_point customer" id="disengage_prank_call" name="data[disengage_prank_call]" required>
                        <option amd_val=10 amd_max=10 <?= ($pilgrim['disengage_prank_call']=="Yes")?"selected":""?> value="Yes">Yes</option>
                        <option amd_val=0 amd_max=10 <?= ($pilgrim['disengage_prank_call']=="No")?"selected":""?> value="No">No</option>
                        <option amd_val=10 amd_max=10 <?= ($pilgrim['disengage_prank_call']=="NA")?"selected":""?> value="NA">NA</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt13]" class="form-control" value="<?= $pilgrim['cmt13']?>"/>
                    </td>
                    <td colspan="">Customer Critical</td>
                  </tr>
                  <!-- <tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td class="eml1"></td>
										<td class="eml1" colspan=3 >Other (Any score here =ZERO total for call)</td>
										<td class="eml1">
										</td>
										<td class="eml1"></td>
									</tr> -->
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td>Other (Any score here = Zero total for the call)</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Critical Accuracy</td>
									</tr>
									<tr>
                    <td class="eml" style="color:red">Rude Remarks</td>
                    <td>1</td>
                    <td>
                      <select class="form-control amd_pilgrim_point compliancee all_fatal1" id="rude_remarks" name="data[rude_remarks]" required>
                        <option amd_val=1 amd_max=1 <?= ($pilgrim['rude_remarks']=="Yes")?"selected":""?> value="Yes">Pass</option>
                        <option amd_val=0 amd_max=1 <?= ($pilgrim['rude_remarks']=="No")?"selected":""?> value="No">Fail</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt14]" class="form-control" value="<?= $pilgrim['cmt14']?>"/>
                    </td>
                    <td colspan="">Compliance Critical</td>
                  </tr>
                  <tr>
                    <td class="eml" style="color:red">Call Avoidance / Dumping</td>
                    <td>1</td>
                    <td>
                      <select class="form-control amd_pilgrim_point compliancee all_fatal2" id="call_avoidance" name="data[call_avoidance]" required>
                        <option amd_val=1 amd_max=1 <?= ($pilgrim['call_avoidance']=="Yes")?"selected":""?> value="Yes">Pass</option>
                        <option amd_val=0 amd_max=1 <?= ($pilgrim['call_avoidance']=="No")?"selected":""?> value="No">Fail</option>
                      </select>
                    </td>
                    <td colspan="2">
                      <input type="text" name="data[cmt15]" class="form-control" value="<?= $pilgrim['cmt15']?>"/>
                    </td>
                    <td colspan="">Compliance Critical</td>
                  </tr>

                  <tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan=2>Compliance</td>
										<td colspan=2>Customer</td>
										<td colspan=2>Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td><input type="text" readonly class="form-control" id="compllockEarned1" name="data[compliancescore]" value="<?php echo $pilgrim['compliancescore'] ?>"></td>
										<td>Earned Point:</td><td><input type="text" readonly class="form-control" id="custlockEarned1" name="data[customerscore]" value="<?php echo $pilgrim['customerscore']?>"></td>
										<td>Earned Point:</td><td><input type="text" readonly class="form-control" id="busilockEarned1" name="data[businessscore]" value="<?php echo $pilgrim['businessscore']?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td><input type="text" readonly class="form-control" id="compllockPossible1" name="data[compliancescoreable]" value="<?php echo $pilgrim['compliancescoreable']?>"></td>
										<td>Possible Point:</td><td><input type="text" readonly class="form-control" id="custlockPossible1" name="data[customerscoreable]" value="<?php echo $pilgrim['customerscoreable']?>"></td>
										<td>Possible Point:</td><td><input type="text" readonly class="form-control" id="busilockPossible1" name="data[businessscoreable]" value="<?php echo $pilgrim['businessscoreable']?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td><input type="text" readonly class="form-control" id="compllockScore" name="data[compliance_score_percent]" value="<?php echo $pilgrim['compliance_score_percent'].'%'?>"></td>
										<td>Overall Percentage:</td><td><input type="text" readonly class="form-control" id="custlockScore" name="data[customer_score_percent]" value="<?php echo $pilgrim['customer_score_percent'].'%'?>"></td>
										<td>Overall Percentage:</td><td><input type="text" readonly class="form-control" id="busilockScore" name="data[business_score_percent]" value="<?php echo $pilgrim['business_score_percent'].'%'?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td><textarea class="form-control" id="" name="data[call_summary]"><?php echo $pilgrim['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="3"><textarea class="form-control" id="" name="data[feedback]"><?php echo $pilgrim['feedback'] ?></textarea></td>
									</tr>

									<?php if($pilgrim_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files</td>
										<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($pilgrim['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$pilgrim['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/pilgrim/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/pilgrim/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>

									<?php if($pilgrim_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $pilgrim['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $pilgrim['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $pilgrim['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $pilgrim['client_rvw_note'] ?></td></tr>

										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>

									<?php
									if($pilgrim_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php
										}
									}else{
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($pilgrim['entry_date'],72) == true){ ?>
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
