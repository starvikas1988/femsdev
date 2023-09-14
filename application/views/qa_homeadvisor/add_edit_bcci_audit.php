<style>
	.table>tbody>tr>td {
		text-align: center;
		font-size: 13px;
	}

	#theader {
		font-size: 20px;
		font-weight: bold;
		background-color: #95A5A6;
	}

	.eml {
		background-color: #85C1E9;
	}
	.fatal .eml{
		background-color: red;
		color:white;
	}
    .fatal{
        color:red;
    }
    .ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
     float: left;
     display: none;
    }
</style>
<?php if ($bcci_id != 0) {
	if (is_access_qa_edit_feedback() == false) { ?>
		<style>
			.form-control {
				pointer-events: none;
				background-color: #D5DBDB;
			}
		</style>
<?php }
} ?>
<div class="wrap">
    <section class="app-content">
        <div class="row">
            <div class="col-12">
                <div class="widget">
                    <form action="" method="POST" enctype="multipart/form-data" id="form_audit_user">
                        <div class="widget-body">
                            <div class="table-responsive">
                                <table class="table table-striped skt-table">
                                    <tbody>
                                        <tr>
                                            <td colspan="6" id="theader" style="font-size:40px;">BCCI</td>
                                        </tr>
                                        <?php
										if ($bcci_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val = '';
										} else {
											if ($bcci['entry_by'] != '') {
												$auditorName = $bcci['auditor_name'];
											} else {
												$auditorName = $bcci['client_name'];
											}
											$auditDate = mysql2mmddyy($bcci['audit_date']);
											$clDate_val = mysql2mmddyy($bcci['call_date']);
                                            $tl_name = $bcci['tl_name'];
                                            $call_duration = $bcci['call_duration'];
										}
										?>
                                        <tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?= $clDate_val; ?>" required></td>
										</tr>
                                        <tr>
											<td>Employee Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<option value="<?php echo $bcci['agent_id'] ?>"><?php echo $bcci['fname'] . " " . $bcci['lname'] ?></option>
													<option value="">-Select-</option>
													<?php foreach ($agentName as $row) :  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Employee ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $bcci['fusion_id'] ?>" readonly></td>
											<td>L1 <br>Supervisor:</td>
											<td>
                                                <input type="text" class="form-control" id="tl_name"  value="<?php echo $bcci['tl_name']; ?>" readonly>
                                                <input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $bcci['tl_id']; ?>" required>
											</td>
										</tr>
                                        <tr>
                                            <td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
                                            <td><input type="text" name="data[call_duration]" id="call_duration" class="form-control" value="<?= $bcci['call_duration']?>" /></td>
                                            <td>Week: <span style="font-size:24px;color:red">*</span></td>
                                            <td>
                                                <select name="data[week]" class="form-control">
                                                    <option value="">-- SELECT --</option>
                                                    <option value="1" <?= ($bcci['week']=="1")?"selected":"" ?>>1</option>
                                                    <option value="2" <?= ($bcci['week']=="2")?"selected":"" ?>>2</option>
                                                    <option value="3" <?= ($bcci['week']=="3")?"selected":"" ?>>3</option>
                                                    <option value="4" <?= ($bcci['week']=="4")?"selected":"" ?>>4</option>
                                                    <option value="5" <?= ($bcci['week']=="5")?"selected":"" ?>>5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($bcci['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($bcci['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($bcci['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($bcci['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($bcci['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($bcci['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($bcci['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                     <option value="WoW Call"  <?= ($bcci['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($bcci['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="QA Supervisor Audit"  <?= ($bcci['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>
                                            <td class="auType">Auditor Type:<span style="font-size:24px;color:red">*</span></td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">-Select-</option>
                                                    <option value="Master" <?= ($bcci['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($bcci['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
                                            <td>VOC: <span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													<option value="">-Select-</option>
													<option value="1"  <?= ($bcci['voc']=="1")?"selected":"" ?>>1</option>
                                                    <option value="2"  <?= ($bcci['voc']=="2")?"selected":"" ?>>2</option>
                                                    <option value="3"  <?= ($bcci['voc']=="3")?"selected":"" ?>>3</option>
                                                    <option value="4"  <?= ($bcci['voc']=="4")?"selected":"" ?>>4</option>
                                                    <option value="5"  <?= ($bcci['voc']=="5")?"selected":"" ?>>5</option>
                                                    <option value="6"  <?= ($bcci['voc']=="6")?"selected":"" ?>>6</option>
                                                    <option value="7"  <?= ($bcci['voc']=="7")?"selected":"" ?>>7</option>
                                                    <option value="8"  <?= ($bcci['voc']=="8")?"selected":"" ?>>8</option>
                                                    <option value="9"  <?= ($bcci['voc']=="9")?"selected":"" ?>>9</option>
                                                    <option value="10"  <?= ($bcci['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
                                        </tr>
                                        <!-- <tr>
                                            <td colspan="3">Total QA Score</td>
                                            <td colspan="3"><input type="text" name="data[total_qa_score]" id="total_qa_score" class="form-control"></td>
                                        </tr> -->
                                        <tr>
                                            <td>Call QA Score:</td>
                                            <td><input type="text" readonly value="<?= $bcci['overall_score']?>" name="data[overall_score]" id="call_qa_score" class="form-control"></td>
                                            <td>InContact ID Number:<span style="font-size:24px;color:red">*</span></td>
                                            <td><input type="text" value="<?= $bcci['incontact_ID']?>" name="data[incontact_ID]" id="call_qa_score" class="form-control" required></td>
                                            <td>Call <br>File Number:<span style="font-size:24px;color:red">*</span></td>
                                            <td><input type="text" value="<?= $bcci['call_file_number']?>" name="data[call_file_number]" id="call_file_number" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="eml">BCCI Emotional Currencies QA</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">1. You showed willingness to help the customer</td>
                                            <td colspan="3">
                                                <select name="data[willingness_to_help]" class="form-control bcci_param" required>
                                                    <?php if(isset($bcci['willingness_to_help'])){?>
                                                        <option value="<?= $bcci['willingness_to_help']?>"><?= $common_yes_no[$bcci['willingness_to_help']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">2. You used active listening to fully engage and hear the customer out</td>
                                            <td colspan="3">
                                                <select name="data[active_listening]" class="form-control bcci_param" required>
                                                    <?php if(isset($bcci['active_listening'])){?>
                                                        <option value="<?= $bcci['active_listening']?>"><?= $common_yes_no[$bcci['active_listening']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">3. You provided a sincere apology for their pain points</td>
                                            <td colspan="3">
                                                <select name="data[sincere_apology]" class="form-control bcci_param" required>
                                                    <?php if(isset($bcci['sincere_apology'])){?>
                                                        <option value="<?= $bcci['sincere_apology']?>"><?= $common_yes_no[$bcci['sincere_apology']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">4. You used RRA to isolate and resolve the customers concerns</td>
                                            <td colspan="3">
                                                <select name="data[rra_isolate]" class="form-control bcci_param">
                                                    <?php if(isset($bcci['rra_isolate'])){?>
                                                        <option value="<?= $bcci['rra_isolate']?>"><?= $common_yes_no[$bcci['rra_isolate']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">5.You offered a concise explanation to provide clarity and assurances for the SP</td>
                                            <td colspan="3">
                                                <select name="data[offered_concise]" class="form-control bcci_param">
                                                    <?php if(isset($bcci['offered_concise'])){?>
                                                        <option value="<?= $bcci['offered_concise']?>"><?= $common_yes_no[$bcci['offered_concise']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">6. You showed appreciation to the professional that was not a part of the call closing</td>
                                            <td colspan="3">
                                                <select name="data[appreciation_professional]" class="form-control bcci_param">
                                                    <?php if(isset($bcci['appreciation_professional'])){?>
                                                        <option value="<?= $bcci['appreciation_professional']?>"><?= $common_yes_no[$bcci['appreciation_professional']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="eml">Engagement</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">7. You did not interrupt the customer</td>
                                            <td colspan="3">
                                                <select name="data[interrupt_cust]" class="form-control bcci_param">
                                                    <?php if(isset($bcci['interrupt_cust'])){?>
                                                        <option value="<?= $bcci['interrupt_cust']?>"><?= $common_yes_no[$bcci['interrupt_cust']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">8. You maintained proper tone, word choice, and rate of speech during the call</td>
                                            <td colspan="3">
                                                <select name="data[maintain_proper_tone]" class="form-control bcci_param">
                                                    <?php if(isset($bcci['maintain_proper_tone'])){?>
                                                        <option value="<?= $bcci['maintain_proper_tone']?>"><?= $common_yes_no[$bcci['maintain_proper_tone']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">9. You set correct expectations throughout the call</td>
                                            <td colspan="3">
                                                <select name="data[correct_expect]" class="form-control bcci_param">
                                                    <?php if(isset($bcci['correct_expect'])){?>
                                                        <option value="<?= $bcci['correct_expect']?>"><?= $common_yes_no[$bcci['correct_expect']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">10. You inform the SP of Self Serve options</td>
                                            <td colspan="3">
                                                <select name="data[inform_sp]" class="form-control bcci_param">
                                                    <?php if(isset($bcci['inform_sp'])){?>
                                                        <option value="<?= $bcci['inform_sp']?>"><?= $common_yes_no[$bcci['inform_sp']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">11. You mentioned all health triggers on the account before the call ended</td>
                                            <td colspan="3">
                                                <select name="data[mention_health]" class="form-control bcci_param">
                                                    <?php if(isset($bcci['mention_health'])){?>
                                                        <option value="<?= $bcci['mention_health']?>"><?= $common_yes_no[$bcci['mention_health']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_yes_no as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="eml">Retention</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">12. You showed additional willingness to help if the account was 45 days or younger (courtesy credit, and/or sought out manager help, looked at tenure, ratings, etc.)</td>
                                            <td colspan="3">
                                                <select name="data[additional_willingness]" class="form-control bcci_param">
                                                   <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['additional_willingness']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['additional_willingness']=="2")?"selected":"" ?>>Fail</option>
                                                    <option value="3"  <?= ($bcci['additional_willingness']=="3")?"selected":"" ?>>N/A</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Required</td>

                                            <td colspan="3">
                                                <select name="data[required_fatal]" class="form-control bcci_param bcci_fatal" required>
                                                    <?php if(isset($bcci['required_fatal'])){?>
                                                        <option value="<?= $bcci['required_fatal']?>"><?= $common_pass_fail[$bcci['required_fatal']]?></option>
                                                    <?php }
                                                    echo "<option value=''>-- SELECT --</option>";
                                                    foreach($common_pass_fail as $key=>$value){?>
                                                        <option value="<?= $key?>"><?= $value?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="color:red">13. You informed the customer the call may be monitored or recorded if they did not hear it in the IVR</td>
                                            <td colspan="3">
                                                <select name="data[informed_cust_call]" class="form-control">
                                                   <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['informed_cust_call']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['informed_cust_call']=="2")?"selected":"" ?>>Fail</option>
                                                    
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="color:red">14. Your notes included the name of whom we spoke with, a brief, professional, and accurate summary of the conversation</td>
                                            <td colspan="3">
                                                <select name="data[note_incl_name]" class="form-control" required>
                                                   <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['note_incl_name']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['note_incl_name']=="2")?"selected":"" ?>>Fail</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="color:red">15. We verified the account by asking for their phone number, personal name and business name</td>
                                            <td colspan="3">
                                                <select name="data[verified_account]" class="form-control" required>
                                                     <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['verified_account']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['verified_account']=="2")?"selected":"" ?>>Fail</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="eml">Coaching</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" >16. Your introduction was pleasant</td>
                                            <td colspan="3">
                                                <select name="data[intro_pleasant]" class="form-control bcci_param" required>
                                                   <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['intro_pleasant']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['intro_pleasant']=="2")?"selected":"" ?>>Fail</option>
                                                    <option value="3"  <?= ($bcci['intro_pleasant']=="3")?"selected":"" ?>>N/A</option>
                                                   
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">17. You asked for permission to proceed with questions and make suggestions</td>
                                            <td colspan="3">
                                                <select name="data[asked_permission]" class="form-control bcci_param" required>
                                                    <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['asked_permission']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['asked_permission']=="2")?"selected":"" ?>>Fail</option>
                                                    <option value="3"  <?= ($bcci['asked_permission']=="3")?"selected":"" ?>>N/A</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">18. You obtained a CRO</td>
                                            <td colspan="3">
                                                <select name="data[obtain_cro]" class="form-control bcci_param" required>
                                                   <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['obtain_cro']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['obtain_cro']=="2")?"selected":"" ?>>Fail</option>
                                                    <option value="3"  <?= ($bcci['obtain_cro']=="3")?"selected":"" ?>>N/A</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">19. During the conversation, you mentioned any additional programs, features or key points on an account to help provide assistance to the SP</td>
                                            <td colspan="3">
                                                <select name="data[mention_additional_programs]" class="form-control bcci_param" required>
                                                    <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['mention_additional_programs']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['mention_additional_programs']=="2")?"selected":"" ?>>Fail</option>
                                                    <option value="3"  <?= ($bcci['mention_additional_programs']=="3")?"selected":"" ?>>N/A</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">20. The closing was proper and included HA Branding</td>
                                            <td colspan="3">
                                                <select name="data[proper_closing]" class="form-control bcci_param" required>
                                                  <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['proper_closing']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['proper_closing']=="2")?"selected":"" ?>>Fail</option>
                                                    <option value="3"  <?= ($bcci['proper_closing']=="3")?"selected":"" ?>>N/A</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="eml">NPS</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">21. If Stella Survey was received for this interaction, did you receive a 5 star rating? If yes, QA score will increase by 5 points (manager must review and notify QA of 5 star Stella rating).</td>
                                            <td colspan="3">
                                                <select name="data[stella_survey]" class="form-control bcci_param" required>
                                                    <option value="">-Select-</option>
                                                   <option value="1"  <?= ($bcci['stella_survey']=="1")?"selected":"" ?>>Pass</option>
                                                    <option value="2"  <?= ($bcci['stella_survey']=="2")?"selected":"" ?>>Fail</option>
                                                    <option value="3"  <?= ($bcci['stella_survey']=="3")?"selected":"" ?>>N/A</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $bcci['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $bcci['feedback'] ?></textarea></td>
										</tr>
										<tr>
                                            <td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
                                            <?php if ($bcci == 0) { ?>
                                                <td colspan=6>
                                                    <input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
                                                </td>
                                                <?php } else {
                                                if ($bcci['attach_file'] != '') { ?>
                                                    <td colspan=6>
                                                        <input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
                                                        <?php $attach_file = explode(",", $bcci['attach_file']);
                                                        foreach ($attach_file as $mp) { ?>
                                                            <audio controls='' style="background-color:#607F93">
                                                                <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/qa_bcci/<?php echo $mp; ?>" type="audio/ogg">
                                                                <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/qa_bcci/<?php echo $mp; ?>" type="audio/mpeg">
                                                            </audio> </br>
                                                        <?php } ?>
                                                    </td>
                                            <?php } else {
                                                    echo '<td colspan=6>
                                                    <input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
                                                    <b>No Files</b></td>';
                                                }
                                            } ?>
                                        </tr>

										<?php if ($bcci != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=7><?php echo $bcci['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=7><?php echo $bcci['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=7><?php echo $bcci['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=7><?php echo $bcci['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review</td>
												<td colspan=7><textarea class="form-control1" style="width:100%" id="note" name="note"></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($bcci == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=9><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($bcci['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
													</tr>
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