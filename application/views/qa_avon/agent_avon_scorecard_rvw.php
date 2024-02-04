<style>
    .table>tbody>tr>td {
        text-align: center;
        font-size: 13px;
    }

    #theader {
        font-size: 20px;
        font-weight: bold;
    }

    .eml {
        background-color: #85C1E9;
    }
    .fatal .eml{
        background-color: red;
        color:white;
    }
</style>


<div class="wrap">
    <section class="app-content">
        <div class="row">
            <div class="col-12">
                <div class="widget">

                    <div class="widget-body">
                        <div class="table-responsive">
                            <table class="table table-striped skt-table" width="100%">
                                <tbody>
                                    <tr style="background-color:#AEB6BF">
                                        <td colspan="6" id="theader" style="font-size:30px">Avon Scorecard</td>
                                    </tr>
                                    <tr>
                                        <td>QA Name:</td>
                                        <?php if ($avon['entry_by'] != '') {
                                            $auditorName = $avon['auditor_name'];
                                        } else {
                                            $auditorName = $avon['client_name'];
                                        } ?>
                                        <td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
                                        <td>Audit Date:</td>
                                        <td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($avon['audit_date']); ?>" disabled></td>
                                        <td>Email Date:</td>
                                        <td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($avon['call_date']); ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Agent:</td>
                                        <td>
                                            <select class="form-control" disabled>
                                                <option><?php echo $avon['fname'] . " " . $avon['lname'] ?></option>
                                            </select>
                                        </td>
                                        <td>Fusion ID:</td>
                                        <td><input type="text" class="form-control" value="<?php echo $avon['fusion_id'] ?>" disabled></td>
                                        <td>L1 Supervisor:</td>
                                        <td>
                                            <select class="form-control" disabled>
                                                <option><?= $avon['tl_name'] ?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                            <td colspan="2">Avon Scorecard</td>
                                            <td colspan="2">
                                                <select class="form-control" name="data[scorecard]" disabled>
                                                     <option value="">--Select--</option>
                                                    <option value="Inbound" <?= ($avon['scorecard']=="Inbound")?"selected":""?>>Inbound</option>
                                                    <option value="Outbound" <?= ($avon['scorecard']=="Outbound")?"selected":""?>>Outbound</option>
                                                    <option value="SMS" <?= ($avon['scorecard']=="SMS")?"selected":""?>>SMS</option>
                                                    <option value="Ticket" <?= ($avon['scorecard']=="Ticket")?"selected":""?>>Ticket</option>
                                                    <option value="Email" <?= ($avon['scorecard']=="Email")?"selected":""?>>Email</option>
                                                </select>
                                            </td>
                                            
                                             <td colspan="">AHT</td>
                                            <td colspan=""><input type="text" class="form-control" id="aht" name="data[aht]" value="<?php echo $avon['aht'] ?>" disabled></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Digital/Non Digital</td>
                                            <td colspan="2">
                                                <select class="form-control" name="data[digital_non_digital]" disabled>
                                                    <option value="Yes" <?= ($avon['digital_non_digital']=="Yes")?"selected":""?>>Yes</option>
                                                    <option value="No" <?= ($avon['digital_non_digital']=="No")?"selected":""?>>No</option>
                                                </select>
                                            </td>
                                            <td>Week</td>
                                            <td>
                                                <select class="form-control" name="data[week]" disabled>
                                                    <option value="1" <?= ($avon['week']=="1")?"selected":""?>>Week 1</option>
                                                    <option value="2" <?= ($avon['week']=="2")?"selected":""?>>Week 2</option>
                                                    <option value="3" <?= ($avon['week']=="3")?"selected":""?>>Week 3</option>
                                                    <option value="4" <?= ($avon['week']=="4")?"selected":""?>>Week 4</option>
                                                    <option value="5" <?= ($avon['week']=="5")?"selected":""?>>Week 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Audit Type:</td>
                                            <td>
                                                <select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($avon['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($avon['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($avon['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($avon['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($avon['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($avon['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($avon['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
                                            </td>
                                            <td class="auType">Auditor Type</td>
                                            <td class="auType">
                                                <select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="Master" <?= ($avon['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($avon['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
                                            </td>
                                            <td>VOC:</td>
                                            <td>
                                                <select class="form-control" id="voc" name="data[voc]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="1" <?= ($avon['voc']=="1")?"selected":"" ?>>1</option>
                                                    <option value="2" <?= ($avon['voc']=="2")?"selected":"" ?>>2</option>
                                                    <option value="3" <?= ($avon['voc']=="3")?"selected":"" ?>>3</option>
                                                    <option value="4" <?= ($avon['voc']=="4")?"selected":"" ?>>4</option>
                                                    <option value="5" <?= ($avon['voc']=="5")?"selected":"" ?>>5</option>
                                                    <option value="6" <?= ($avon['voc']=="6")?"selected":"" ?>>6</option>
                                                    <option value="7" <?= ($avon['voc']=="7")?"selected":"" ?>>7</option>
                                                    <option value="8" <?= ($avon['voc']=="8")?"selected":"" ?>>8</option>
                                                    <option value="9" <?= ($avon['voc']=="9")?"selected":"" ?>>9</option>
                                                    <option value="10" <?= ($avon['voc']=="10")?"selected":"" ?>>10</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
                                            <td><input type="text" readonly id="avon_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $avon['earned_score'] ?>" /></td>
                                            <td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
                                            <td><input type="text" readonly id="avon_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $avon['possible_score'] ?>" /></td>
                                            <td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
                                            <td><input type="text" readonly id="avon_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $avon['overall_score'] ?>"></td>
                                        </tr>
                                        <tr style="background-color:#34495E; color:white; font-weight:bold; height:35px"><td>Sub-parameter</td><td colspan=2>Description</td><td>Points</td><td>Response</td><td>Remarks</td></tr>
                                   
                                    <tr>
                                        <td>SLA</td>
                                        <td colspan=2>The agent opens the call within the threshold (Trigget ZTP in Inbound)</td>
                                        <td>3.33</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[SLA]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3.33 <?= $avon["SLA"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["SLA"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["SLA"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt1" value="<?php echo $avon['cmt1'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Used Suggested Closing Spiel</td>
                                        <td colspan=2>The agent uses suggested closing spiel based on channel</td>
                                        <td>2.22</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Spiel]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2.22 <?= $avon["Spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt2" value="<?php echo $avon['cmt2'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Additional Assistance</td>
                                        <td colspan=2>The agent asks additional assistance before ending the call/chat</td>
                                        <td>2.22</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Assistance]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2.22 <?= $avon["Assistance"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Assistance"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Assistance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt3" value="<?php echo $avon['cmt3'] ?>" disabled ></td>
                                    </tr>
                                    <tr>
                                        <td>Spiel Adherance</td>
                                        <td colspan=2>Ghost Call / Profanity / Bad Line</td>
                                        <td>2.22</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Adherance]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2.22 <?= $avon["Adherance"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Adherance"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Adherance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt4" value="<?php echo $avon['cmt4'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Did the agent use proper script</td>
                                        <td colspan=2>The agent uses proper script when making an outbound call</td>
                                        <td>6.67</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[proper_script]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=6.67 <?= $avon["proper_script"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["proper_script"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["proper_script"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt5" value="<?php echo $avon['cmt5'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Did the agent acknowledge the issue of the customer?</td>
                                        <td colspan=2>Spontaneous responses from the customers should be acknowledged with priority and with appropriate empathy.</td>
                                        <td>1.67</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[customer]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.67 <?= $avon["customer"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["customer"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["customer"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt6" value="<?php echo $avon['cmt6'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Did the agent provide empathy statement?(when necessary)</td>
                                        <td colspan=2>Spontaneous responses from the customers should be acknowledged with priority and with appropriate empathy.</td>
                                        <td>1.67</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[when_necessary]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.67 <?= $avon["when_necessary"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["when_necessary"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["when_necessary"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt7" value="<?php echo $avon['cmt7'] ?>" disabled></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Did the agent provide assurance to help the customer?</td>
                                        <td colspan=2>Spontaneous responses from the customers should be acknowledged with priority and with appropriate empathy.</td>
                                        <td>1.67</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[provide_assurance]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.67 <?= $avon["provide_assurance"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["provide_assurance"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["provide_assurance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt8" value="<?php echo $avon['cmt8'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Information Shared</td>
                                        <td colspan=2>The agent should provide complete and accurate information</td>
                                        <td>3.33</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Shared]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3.33 <?= $avon["Shared"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Shared"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Shared"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt9" value="<?php echo $avon['cmt9'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Failed to Escalate/Call back</td>
                                        <td colspan=2>The agent should escalate issue with urgency / Need to call the customer back if necessary</td>
                                        <td>3.33</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[Call_back]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3.33 <?= $avon["Call_back"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Call_back"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Call_back"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt10" value="<?php echo $avon['cmt10'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Active Listening/Reading</td>
                                        <td colspan=2>The agent should ablle to identify and understand the issue of the customer / Good comprehension skill</td>
                                        <td>3.33</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[Reading]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3.33 <?= $avon["Reading"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Reading"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Reading"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt11" value="<?php echo $avon['cmt11'] ?>" disabled></td>
                                    </tr>

                                     <tr>
                                        <td>Interruption</td>
                                        <td colspan=2>The agent should pause whenever there's an interruption / apologize if necessary</td>
                                        <td>1.26</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Interruption]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.26 <?= $avon["Interruption"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Interruption"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Interruption"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt12" value="<?php echo $avon['cmt12'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Dead Air and Proper Hold Technique</td>
                                        <td colspan=2>Dead air should not be more than 10 seconds, followed proper hold procedure / For Chat: Agent should respond not more than 2 minutes</td>
                                        <td>1.26</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Technique]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.26 <?= $avon["Technique"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Technique"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Technique"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt13" value="<?php echo $avon['cmt13'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Grammar usage and Technical Writing</td>
                                        <td colspan=2>Conversation are free from any grammatical error / Proper use of punctuation / Proper use of Capitalization and Spacing</td>
                                        <td>1.26</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Writing]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.26 <?= $avon["Writing"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Writing"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Writing"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt14" value="<?php echo $avon['cmt14'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Professionalism (ZTP)</td>
                                        <td colspan=2>Polite, respectful, ethical </td>
                                        <td>1.25</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[professionalism]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.25 <?= $avon["professionalism"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["professionalism"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["professionalism"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt15" value="<?php echo $avon['cmt15'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Interact with intention</td>
                                        <td colspan=2>*Natural & Genuine Tone</td>
                                        <td>4</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[intention]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4 <?= $avon["intention"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["intention"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["intention"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt16" value="<?php echo $avon['cmt16'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Strong Ownership</td>
                                        <td colspan=2>Call control. The agent creates an engaging conversation and creatively routes it to an appropriate resolution in a timely manner.</td>
                                        <td>4</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[Ownership]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4 <?= $avon["Ownership"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Ownership"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Ownership"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt17" value="<?php echo $avon['cmt17'] ?>" disabled></td>
                                    </tr>

                                     <tr>
                                        <td>Tailored Contact</td>
                                        <td colspan=2>Finds an opportunity to stir up a conversation based on the information provided by the customer</td>
                                        <td>4</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[Contact]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4 <?= $avon["Contact"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Contact"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Contact"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt18" value="<?php echo $avon['cmt18'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Tailored Contact</td>
                                        <td colspan=2>Creates an opportunity to stir up a conversation based on the customer's information or other information available in our resources</td>
                                        <td>2</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Contact2]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2 <?= $avon["Contact2"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Contact2"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Contact2"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt19" value="<?php echo $avon['cmt19'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Enthusiasm</td>
                                        <td colspan=2>Sounds appropriately upbeat and perky</td>
                                        <td>2</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Enthusiasm]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2 <?= $avon["Enthusiasm"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Enthusiasm"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Enthusiasm"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt20" value="<?php echo $avon['cmt20'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Avon Security</td>
                                        <td colspan=2>Agent are expected to follow the security protocol in scenarios that needs one (if applicable). </td>
                                        <td>4</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Security]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4 <?= $avon["Security"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Security"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Security"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt21" value="<?php echo $avon['cmt21'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Send to the right approver</td>
                                        <td colspan=2>The agent is expected to send it to approver if it is out of our scope</td>
                                        <td>13.33</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[approver]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=13.33 <?= $avon["approver"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["approver"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["approver"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt22" value="<?php echo $avon['cmt22'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Efficiency of Action</td>
                                        <td colspan=2>Agents must follow the guidelines set for each request.</td>
                                        <td>4.44</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Action]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4.44 <?= $avon["Action"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Action"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Action"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt23" value="<?php echo $avon['cmt23'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Documentation</td>
                                        <td colspan=2>Agent is expected to leave notes/comments accurately.</td>
                                        <td>4.44</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Documentation]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4.44 <?= $avon["Documentation"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["Documentation"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["Documentation"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt24" value="<?php echo $avon['cmt24'] ?>" disabled></td>
                                    </tr>
                                     <tr>
                                        <td>Use proper disposition and tagging</td>
                                        <td colspan=2>The agent should always have good decision making on approving or disapproving a ticket.</td>
                                        <td>4.44</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[tagging]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4.44 <?= $avon["tagging"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon["tagging"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon["tagging"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt25" value="<?php echo $avon['cmt25'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Call Summary:</td>
                                        <td colspan=2><textarea class="form-control" name="data[call_summary]" disabled><?php echo $avon['call_summary'] ?></textarea></td>
                                        <td>Feedback:</td>
                                        <td colspan=2><textarea class="form-control" name="data[feedback]" disabled><?php echo $avon['feedback'] ?></textarea></td>
                                    </tr>
                                    <?php if ($avon['attach_file'] != '') { ?>
                                        <tr oncontextmenu="return false;">
                                            <td colspan="2">Audio Files</td>
                                            <td colspan="4">
                                                <?php $attach_file = explode(",", $avon['attach_file']);
                                                foreach ($attach_file as $mp) { ?>
                                                    <audio controls='' style="background-color:#607F93">
                                                        <source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/ogg">
                                                        <source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/mpeg">
                                                    </audio> </br>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <tr>
                                        <td colspan="6" style="background-color:#C5C8C8"></td>
                                    </tr>

                                    <tr>
                                        <td style="font-size:16px">Manager Review:</td>
                                        <td colspan="5" style="text-align:left"><?php echo $avon['mgnt_rvw_note'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:16px">Client Review:</td>
                                        <td colspan="5" style="text-align:left"><?php echo $avon['client_rvw_note'] ?></td>
                                    </tr>

                                    <tr>
                                        <td colspan="6" style="background-color:#C5C8C8"></td>
                                    </tr>

                                    <form id="form_agent_user" method="POST" action="">
                                        <input type="hidden" name="pnid" class="form-control" value="<?= $pnid; ?>">

                                        <tr>
                                            <td colspan=2 style="font-size:16px">Feedback Acceptance</td>
                                            <td colspan=2>
                                                <select class="form-control" id="" name="agnt_fd_acpt" required="">
                                                    <option value="">--Select--</option>
                                                    <option <?php echo $avon['agnt_fd_acpt'] == 'Acceptance' ? "selected" : ""; ?> value="Acceptance">Acceptance</option>
                                                    <option <?php echo $avon['agnt_fd_acpt'] == 'Not Acceptance' ? "selected" : ""; ?> value="Not Acceptance">Not Acceptance</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan=2 style="font-size:16px">Your Review</td>
                                            <td colspan=4><textarea class="form-control" name="note" required=""><?php echo $avon['agent_rvw_note'] ?></textarea></td>
                                        </tr>

                                        <?php if (is_access_qa_agent_module() == true) {
                                            if (is_available_qa_feedback($avon['entry_date'], 72) == true) { ?>
                                                <tr>
                                                    <?php if ($avon['agent_rvw_note'] == '') { ?>
                                                        <td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
                                                    <?php } ?>
                                                </tr>
                                        <?php }
                                        } ?>

                                    </form>

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