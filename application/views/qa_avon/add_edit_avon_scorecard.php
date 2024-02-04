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
</style>

<?php if ($avon_id != 0) {
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
                    <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">

                        <div class="widget-body">
                            <div class="table-responsive">
                                <table class="table table-striped skt-table" width="100%">
                                    <tbody>
                                        <tr>
                                            <td colspan="6" id="theader" style="font-size:40px">Avon Scorecard</td>
                                            <input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
                                        </tr>
                                        <?php
                                        if ($avon_id == 0) {
                                            $auditorName = get_username();
                                            $auditDate = CurrDateMDY();
                                            $clDate_val = '';
                                        } else {
                                            if ($avon_scorecard['entry_by'] != '') {
                                                $auditorName = $avon_scorecard['auditor_name'];
                                            } else {
                                                $auditorName = $avon_scorecard['client_name'];
                                            }
                                            $auditDate = mysql2mmddyy($avon_scorecard['audit_date']);
                                            $clDate_val = mysql2mmddyy($avon_scorecard['call_date']);
                                        }
                                        ?>
                                        <tr>
                                            <td>Auditor Name:</td>
                                            <td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
                                            <td>Audit Date:</td>
                                            <td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
                                            <td>Email Date:</td>
                                            <td><input type="text" class="form-control" id="call_date" name="call_date" value="<?= $clDate_val; ?>" required></td>
                                        </tr>
                                        <tr>
                                            <td>Employee Name:</td>
                                            <td>
                                                <select class="form-control" id="agent_id" name="data[agent_id]" required>
                                                    <option value="<?php echo $avon_scorecard['agent_id'] ?>"><?php echo $avon_scorecard['fname'] . " " . $avon_scorecard['lname'] ?></option>
                                                    <option value="">-Select-</option>
                                                    <?php foreach ($agentName as $row) :  ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>Employee ID:</td>
                                            <td><input type="text" class="form-control" id="fusion_id" value="<?php echo $avon_scorecard['fusion_id'] ?>" readonly></td>
                                            <td>L1 Supervisor:</td>
                                            <td>
                                                <select class="form-control" id="tl_id" name="data[tl_id]" readonly>
                                                    <option value="<?php echo $avon_scorecard['tl_id'] ?>"><?php echo $avon_scorecard['tl_name'] ?></option>
                                                    <option value="">--Select--</option>
                                                    <?php foreach ($tlname as $tl) : ?>
                                                        <option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname'] . " " . $tl['lname']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Avon Scorecard</td>
                                            <td colspan="2">
                                                <select class="form-control" name="data[scorecard]">
                                                     <option value="">--Select--</option>
                                                    <option value="Inbound" <?= ($avon_scorecard['scorecard']=="Inbound")?"selected":""?>>Inbound</option>
                                                    <option value="Outbound" <?= ($avon_scorecard['scorecard']=="Outbound")?"selected":""?>>Outbound</option>
                                                    <option value="SMS" <?= ($avon_scorecard['scorecard']=="SMS")?"selected":""?>>SMS</option>
                                                    <option value="Ticket" <?= ($avon_scorecard['scorecard']=="Ticket")?"selected":""?>>Ticket</option>
                                                    <option value="Email" <?= ($avon_scorecard['scorecard']=="Email")?"selected":""?>>Email</option>
                                                </select>
                                            </td>
                                            
                                             <td colspan="">AHT</td>
                                            <td colspan=""><input type="text" class="form-control" id="aht" name="data[aht]" value="<?php echo $avon_scorecard['aht'] ?>" required></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Digital/Non Digital</td>
                                            <td colspan="2">
                                                <select class="form-control" name="data[digital_non_digital]" required>
                                                    <option value="Yes" <?= ($avon_scorecard['digital_non_digital']=="Yes")?"selected":""?>>Yes</option>
                                                    <option value="No" <?= ($avon_scorecard['digital_non_digital']=="No")?"selected":""?>>No</option>
                                                </select>
                                            </td>
                                            <td>Week</td>
                                            <td>
                                                <select class="form-control" name="data[week]" required>
                                                    <option value="1" <?= ($avon_scorecard['week']=="1")?"selected":""?>>Week 1</option>
                                                    <option value="2" <?= ($avon_scorecard['week']=="2")?"selected":""?>>Week 2</option>
                                                    <option value="3" <?= ($avon_scorecard['week']=="3")?"selected":""?>>Week 3</option>
                                                    <option value="4" <?= ($avon_scorecard['week']=="4")?"selected":""?>>Week 4</option>
                                                    <option value="5" <?= ($avon_scorecard['week']=="5")?"selected":""?>>Week 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Audit Type:</td>
                                            <td>
                                                <select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($avon_scorecard['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($avon_scorecard['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($avon_scorecard['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($avon_scorecard['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($avon_scorecard['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($avon_scorecard['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($avon_scorecard['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
                                            </td>
                                            <td class="auType">Auditor Type</td>
                                            <td class="auType">
                                                <select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">-Select-</option>
                                                    <option value="Master" <?= ($avon_scorecard['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($avon_scorecard['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
                                            </td>
                                            <td>VOC:</td>
                                            <td>
                                                <select class="form-control" id="voc" name="data[voc]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="1" <?= ($avon_scorecard['voc']=="1")?"selected":"" ?>>1</option>
                                                    <option value="2" <?= ($avon_scorecard['voc']=="2")?"selected":"" ?>>2</option>
                                                    <option value="3" <?= ($avon_scorecard['voc']=="3")?"selected":"" ?>>3</option>
                                                    <option value="4" <?= ($avon_scorecard['voc']=="4")?"selected":"" ?>>4</option>
                                                    <option value="5" <?= ($avon_scorecard['voc']=="5")?"selected":"" ?>>5</option>
                                                    <option value="6" <?= ($avon_scorecard['voc']=="6")?"selected":"" ?>>6</option>
                                                    <option value="7" <?= ($avon_scorecard['voc']=="7")?"selected":"" ?>>7</option>
                                                    <option value="8" <?= ($avon_scorecard['voc']=="8")?"selected":"" ?>>8</option>
                                                    <option value="9" <?= ($avon_scorecard['voc']=="9")?"selected":"" ?>>9</option>
                                                    <option value="10" <?= ($avon_scorecard['voc']=="10")?"selected":"" ?>>10</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
                                            <td><input type="text" readonly id="avon_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $avon_scorecard['earned_score'] ?>" /></td>
                                            <td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
                                            <td><input type="text" readonly id="avon_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $avon_scorecard['possible_score'] ?>" /></td>
                                            <td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
                                            <td><input type="text" readonly id="avon_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $avon_scorecard['overall_score'] ?>"></td>
                                        </tr>
                                        <tr style="background-color:#34495E; color:white; font-weight:bold; height:35px"><td>Sub-parameter</td><td colspan=2>Description</td><td>Points</td><td>Response</td><td>Remarks</td></tr>
                                   
                                    <tr>
                                        <td>SLA</td>
                                        <td colspan=2>The agent opens the call within the threshold (Trigget ZTP in Inbound)</td>
                                        <td>3.33</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[SLA]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3.33 <?= $avon_scorecard["SLA"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["SLA"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["SLA"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt1" value="<?php echo $avon_scorecard['cmt1'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Used Suggested Closing Spiel</td>
                                        <td colspan=2>The agent uses suggested closing spiel based on channel</td>
                                        <td>2.22</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Spiel]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2.22 <?= $avon_scorecard["Spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt2" value="<?php echo $avon_scorecard['cmt2'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Additional Assistance</td>
                                        <td colspan=2>The agent asks additional assistance before ending the call/chat</td>
                                        <td>2.22</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Assistance]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2.22 <?= $avon_scorecard["Assistance"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Assistance"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Assistance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt3" value="<?php echo $avon_scorecard['cmt3'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Spiel Adherance</td>
                                        <td colspan=2>Ghost Call / Profanity / Bad Line</td>
                                        <td>2.22</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Adherance]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2.22 <?= $avon_scorecard["Adherance"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Adherance"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Adherance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt4" value="<?php echo $avon_scorecard['cmt4'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Did the agent use proper script</td>
                                        <td colspan=2>The agent uses proper script when making an outbound call</td>
                                        <td>6.67</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[proper_script]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=6.67 <?= $avon_scorecard["proper_script"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["proper_script"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["proper_script"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt5" value="<?php echo $avon_scorecard['cmt5'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Did the agent acknowledge the issue of the customer?</td>
                                        <td colspan=2>Spontaneous responses from the customers should be acknowledged with priority and with appropriate empathy.</td>
                                        <td>1.67</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[customer]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.67 <?= $avon_scorecard["customer"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["customer"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["customer"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt6" value="<?php echo $avon_scorecard['cmt6'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Did the agent provide empathy statement?(when necessary)</td>
                                        <td colspan=2>Spontaneous responses from the customers should be acknowledged with priority and with appropriate empathy.</td>
                                        <td>1.67</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[when_necessary]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.67 <?= $avon_scorecard["when_necessary"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["when_necessary"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["when_necessary"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt7" value="<?php echo $avon_scorecard['cmt7'] ?>"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Did the agent provide assurance to help the customer?</td>
                                        <td colspan=2>Spontaneous responses from the customers should be acknowledged with priority and with appropriate empathy.</td>
                                        <td>1.67</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[provide_assurance]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.67 <?= $avon_scorecard["provide_assurance"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["provide_assurance"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["provide_assurance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt8" value="<?php echo $avon_scorecard['cmt8'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Information Shared</td>
                                        <td colspan=2>The agent should provide complete and accurate information</td>
                                        <td>3.33</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Shared]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3.33 <?= $avon_scorecard["Shared"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Shared"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Shared"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt9" value="<?php echo $avon_scorecard['cmt9'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Failed to Escalate/Call back</td>
                                        <td colspan=2>The agent should escalate issue with urgency / Need to call the customer back if necessary</td>
                                        <td>3.33</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[Call_back]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3.33 <?= $avon_scorecard["Call_back"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Call_back"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Call_back"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt10" value="<?php echo $avon_scorecard['cmt10'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Active Listening/Reading</td>
                                        <td colspan=2>The agent should ablle to identify and understand the issue of the customer / Good comprehension skill</td>
                                        <td>3.33</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[Reading]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3.33 <?= $avon_scorecard["Reading"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Reading"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Reading"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt11" value="<?php echo $avon_scorecard['cmt11'] ?>"></td>
                                    </tr>

                                     <tr>
                                        <td>Interruption</td>
                                        <td colspan=2>The agent should pause whenever there's an interruption / apologize if necessary</td>
                                        <td>1.26</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Interruption]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.26 <?= $avon_scorecard["Interruption"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Interruption"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Interruption"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt12" value="<?php echo $avon_scorecard['cmt12'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Dead Air and Proper Hold Technique</td>
                                        <td colspan=2>Dead air should not be more than 10 seconds, followed proper hold procedure / For Chat: Agent should respond not more than 2 minutes</td>
                                        <td>1.26</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Technique]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.26 <?= $avon_scorecard["Technique"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Technique"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Technique"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt13" value="<?php echo $avon_scorecard['cmt13'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Grammar usage and Technical Writing</td>
                                        <td colspan=2>Conversation are free from any grammatical error / Proper use of punctuation / Proper use of Capitalization and Spacing</td>
                                        <td>1.26</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Writing]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.26 <?= $avon_scorecard["Writing"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Writing"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Writing"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt14" value="<?php echo $avon_scorecard['cmt14'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Professionalism (ZTP)</td>
                                        <td colspan=2>Polite, respectful, ethical </td>
                                        <td>1.25</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[professionalism]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1.25 <?= $avon_scorecard["professionalism"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["professionalism"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["professionalism"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt15" value="<?php echo $avon_scorecard['cmt15'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Interact with intention</td>
                                        <td colspan=2>*Natural & Genuine Tone</td>
                                        <td>4</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[intention]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4 <?= $avon_scorecard["intention"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["intention"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["intention"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt16" value="<?php echo $avon_scorecard['cmt16'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Strong Ownership</td>
                                        <td colspan=2>Call control. The agent creates an engaging conversation and creatively routes it to an appropriate resolution in a timely manner.</td>
                                        <td>4</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[Ownership]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4 <?= $avon_scorecard["Ownership"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Ownership"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Ownership"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt17" value="<?php echo $avon_scorecard['cmt17'] ?>"></td>
                                    </tr>

                                     <tr>
                                        <td>Tailored Contact</td>
                                        <td colspan=2>Finds an opportunity to stir up a conversation based on the information provided by the customer</td>
                                        <td>4</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[Contact]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4 <?= $avon_scorecard["Contact"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Contact"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Contact"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt18" value="<?php echo $avon_scorecard['cmt18'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Tailored Contact</td>
                                        <td colspan=2>Creates an opportunity to stir up a conversation based on the customer's information or other information available in our resources</td>
                                        <td>2</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Contact2]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2 <?= $avon_scorecard["Contact2"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Contact2"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Contact2"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt19" value="<?php echo $avon_scorecard['cmt19'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Enthusiasm</td>
                                        <td colspan=2>Sounds appropriately upbeat and perky</td>
                                        <td>2</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Enthusiasm]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=2 <?= $avon_scorecard["Enthusiasm"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Enthusiasm"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Enthusiasm"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt20" value="<?php echo $avon_scorecard['cmt20'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Avon Security</td>
                                        <td colspan=2>Agent are expected to follow the security protocol in scenarios that needs one (if applicable). </td>
                                        <td>4</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Security]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4 <?= $avon_scorecard["Security"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Security"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Security"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt21" value="<?php echo $avon_scorecard['cmt21'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Send to the right approver</td>
                                        <td colspan=2>The agent is expected to send it to approver if it is out of our scope</td>
                                        <td>13.33</td>
                                        <td>
                                           <select class="form-control avon_point" name="data[approver]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=13.33 <?= $avon_scorecard["approver"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["approver"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["approver"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt22" value="<?php echo $avon_scorecard['cmt22'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Efficiency of Action</td>
                                        <td colspan=2>Agents must follow the guidelines set for each request.</td>
                                        <td>4.44</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Action]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4.44 <?= $avon_scorecard["Action"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Action"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Action"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt23" value="<?php echo $avon_scorecard['cmt23'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Documentation</td>
                                        <td colspan=2>Agent is expected to leave notes/comments accurately.</td>
                                        <td>4.44</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[Documentation]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4.44 <?= $avon_scorecard["Documentation"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Documentation"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["Documentation"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt24" value="<?php echo $avon_scorecard['cmt24'] ?>"></td>
                                    </tr>
                                     <tr>
                                        <td>Use proper disposition and tagging</td>
                                        <td colspan=2>The agent should always have good decision making on approving or disapproving a ticket.</td>
                                        <td>4.44</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[tagging]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=4.44 <?= $avon_scorecard["tagging"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_scorecard["tagging"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_scorecard["tagging"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cmt25" value="<?php echo $avon_scorecard['cmt25'] ?>"></td>
                                    </tr>
                                    
                                    
                                    
                                        <tr>
                                            <td>Call Summary:</td>
                                            <td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $avon_scorecard['call_summary'] ?></textarea></td>
                                            <td>Feedback:</td>
                                            <td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $avon_scorecard['feedback'] ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan=2>Upload Files</td>
                                            <?php if ($avon_id == 0) { ?>
                                                <td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
                                                <?php } else {
                                                if ($avon_scorecard['attach_file'] != '') { ?>
                                                    <td colspan=4>
                                                        <?php $attach_file = explode(",", $avon_scorecard['attach_file']);
                                                        foreach ($attach_file as $mp) { ?>
                                                            <audio controls='' style="background-color:#607F93">
                                                                <source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/ogg">
                                                                <source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/mpeg">
                                                            </audio> </br>
                                                        <?php } ?>
                                                    </td>
                                            <?php } else {
                                                    echo '<td colspan=6><b>No Files</b></td>';
                                                }
                                            } ?>
                                        </tr>

                                        <?php if ($avon_id != 0) { ?>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
                                                <td colspan=4><?php echo $avon_scorecard['agnt_fd_acpt'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
                                                <td colspan=4><?php echo $avon_scorecard['agent_rvw_note'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
                                                <td colspan=4><?php echo $avon_scorecard['mgnt_rvw_note'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
                                                <td colspan=4><?php echo $avon_scorecard['client_rvw_note'] ?></td>
                                            </tr>

                                            <tr>
                                                <td colspan=2 style="font-size:16px">Your Review</td>
                                                <td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"></textarea></td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        if ($avon_id == 0) {
                                            if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
                                                <tr>
                                                    <td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
                                                if (is_available_qa_feedback($avon_scorecard['entry_date'], 72) == true) { ?>
                                                    <tr>
                                                        <td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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