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
                                            <td colspan="6" id="theader" style="font-size:40px">Avon</td>
                                            <input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
                                        </tr>
                                        <?php
                                        if ($avon_id == 0) {
                                            $auditorName = get_username();
                                            $auditDate = CurrDateMDY();
                                            $clDate_val = '';
                                        } else {
                                            if ($avon_sms['entry_by'] != '') {
                                                $auditorName = $avon_sms['auditor_name'];
                                            } else {
                                                $auditorName = $avon_sms['client_name'];
                                            }
                                            $auditDate = mysql2mmddyy($avon_sms['audit_date']);
                                            $clDate_val = mysql2mmddyy($avon_sms['call_date']);
                                        }
                                        ?>
                                        <tr>
                                            <td>Auditor Name:</td>
                                            <td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
                                            <td>Audit Date:</td>
                                            <td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
                                            <td>SMS Date:</td>
                                            <td><input type="text" class="form-control" id="call_date" name="call_date" value="<?= $clDate_val; ?>" required></td>
                                        </tr>
                                        <tr>
                                            <td>Employee Name:</td>
                                            <td>
                                                <select class="form-control" id="agent_id" name="data[agent_id]" required>
                                                    <option value="<?php echo $avon_sms['agent_id'] ?>"><?php echo $avon_sms['fname'] . " " . $avon_sms['lname'] ?></option>
                                                    <option value="">-Select-</option>
                                                    <?php foreach ($agentName as $row) :  ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>Employee ID:</td>
                                            <td><input type="text" class="form-control" id="fusion_id" value="<?php echo $avon_sms['fusion_id'] ?>" readonly></td>
                                            <td>L1 Supervisor:</td>
                                            <td>
                                                <select class="form-control" id="tl_id" name="data[tl_id]" readonly>
                                                    <option value="<?php echo $avon_sms['tl_id'] ?>"><?php echo $avon_sms['tl_name'] ?></option>
                                                    <option value="">--Select--</option>
                                                    <?php foreach ($tlname as $tl) : ?>
                                                        <option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname'] . " " . $tl['lname']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">AHT:</td>
                                            <td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $avon_sms['call_duration'] ?>" required></td>
                                            <td>Type of SMS:</td>
                                            <td><input type="text" class="form-control" name="data[sms_type]" value="<?php echo $avon_sms['sms_type'] ?>" required></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Digital/Non Digital</td>
                                            <td colspan="2">
                                                <select class="form-control" name="data[digital_non_digital]" required>
                                                    <?php if($avon_sms['digital_non_digital']){ ?>
                                                    <option value="<?php echo $avon_sms['digital_non_digital'] ?>"><?php echo $avon_sms['digital_non_digital'] ?></option><?php }?>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </td>
                                            <td>Week</td>
                                            <td>
                                                <select class="form-control" name="data[week]" required>
                                                    <option value="<?php echo $avon_sms['week'] ?>"><?php echo $avon_sms['week'] ?></option>
                                                    <option value="1">Week 1</option>
                                                    <option value="2">Week 2</option>
                                                    <option value="3">Week 3</option>
                                                    <option value="4">Week 4</option>
                                                    <option value="5">Week 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Audit Type:</td>
                                            <td>
                                                <select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="<?php echo $avon_sms['audit_type'] ?>"><?php echo $avon_sms['audit_type'] ?></option>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit">CQ Audit</option>
                                                    <option value="BQ Audit">BQ Audit</option>
                                                    <option value="Calibration">Calibration</option>
                                                    <option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit">Certification Audit</option>
                                                    <option value="Operation Audit">Operation Audit</option>
                                                    <option value="Trainer Audit">Trainer Audit</option>
                                                </select>
                                            </td>
                                            <td class="auType">Auditor Type</td>
                                            <td class="auType">
                                                <select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="<?php echo $avon_sms['auditor_type'] ?>"><?php echo $avon_sms['auditor_type'] ?></option>
                                                    <option value="">-Select-</option>
                                                    <option value="Master">Master</option>
                                                    <option value="Regular">Regular</option>
                                                </select>
                                            </td>
                                            <td>VOC:</td>
                                            <td>
                                                <select class="form-control" id="voc" name="data[voc]" required>
                                                    <option value="<?php echo $avon_sms['voc'] ?>"><?php echo $avon_sms['voc'] ?></option>
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
                                            <td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
                                            <td><input type="text" readonly id="avon_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $avon_sms['earned_score'] ?>" /></td>
                                            <td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
                                            <td><input type="text" readonly id="avon_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $avon_sms['possible_score'] ?>" /></td>
                                            <td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
                                            <td><input type="text" readonly id="avon_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $avon_sms['overall_score'] ?>"></td>
                                        </tr>
                                        <tr class="eml" style="height:25px; font-weight:bold">
                                            <td>PARAMETER</td>
                                            <td colspan=2>SUB PARAMETER</td>
                                            <td>STATUS</td>
                                            <td colspan=2>REMARKS</td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Standard Greeting</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[standard_greeting]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?php echo $avon_sms['standard_greeting'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?php echo $avon_sms['standard_greeting'] == "No" ? "selected" : ""; ?> value="No">No</option>
                                                    <option avon_val=0 <?php echo $avon_sms['standard_greeting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon_sms['cmt1'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Sentence Construction</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[sentence_construction]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_sms["sentence_construction"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["sentence_construction"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["sentence_construction"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $avon_sms['cmt2'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Professionalism</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[professionalism]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_sms["professionalism"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["professionalism"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["professionalism"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $avon_sms['cmt3'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Empathy</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[empathy]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_sms["empathy"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["empathy"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["empathy"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $avon_sms['cmt4'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Probing Questions (If Applicable)</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[probing_question_if_applicable]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_sms["probing_question_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["probing_question_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["probing_question_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $avon_sms['cmt5'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Comprehension</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[comprehension]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_sms["comprehension"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["comprehension"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["comprehension"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $avon_sms['cmt6'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Correct Disposition</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[correct_disposition]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_sms["correct_disposition"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["correct_disposition"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["correct_disposition"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $avon_sms['cmt7'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Avon Security</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[avon_security]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=5 <?= $avon_sms["avon_security"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["avon_security"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["avon_security"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $avon_sms['cmt8'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3" class="eml">FTR</td>
                                            <td colspan="2">Information Shared</td>
                                            <td rowspan="3">
                                                <select class="form-control avon_point" name="data[first_call_resolution]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=5 <?= $avon_sms["first_call_resolution"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["first_call_resolution"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["first_call_resolution"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td rowspan="3" colspan="2">
                                                <input type="text" name="data[cmt9]" class="form-control" value="<?php echo $avon_sms['cmt9'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Failed to Escalate</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Others</td>
                                        </tr>
                                        <tr>
                                            <td class="eml" rowspan="2">Shared Information</td>
                                            <td colspan="2">Incomplete Information</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[information_shared_incomplete]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=10 <?= $avon_sms["information_shared_incomplete"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["information_shared_incomplete"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["information_shared_incomplete"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $avon_sms['cmt10'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Inaccurate Information</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[information_shared_inaccurate]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=10 <?= $avon_sms["information_shared_inaccurate"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["information_shared_inaccurate"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["information_shared_inaccurate"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $avon_sms['cmt11'] ?>"></td>
                                        </tr>
                                        <tr class="fatal">
                                            <td colspan="3" class="eml">Rudeness</td>
                                            <td>
                                                <select class="form-control avon_point avon_fatal" name="data[rudeness]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=0 <?= $avon_sms["rudeness"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_sms["rudeness"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_sms["rudeness"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $avon_sms['cmt12'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Call Summary:</td>
                                            <td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $avon_sms['call_summary'] ?></textarea></td>
                                            <td>Feedback:</td>
                                            <td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $avon_sms['feedback'] ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan=2>Upload Files</td>
                                            <?php if ($avon_id == 0) { ?>
                                                <td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
                                                <?php } else {
                                                if ($avon_sms['attach_file'] != '') { ?>
                                                    <td colspan=4>
                                                        <?php $attach_file = explode(",", $avon_sms['attach_file']);
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
                                                <td colspan=4><?php echo $avon_sms['agnt_fd_acpt'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
                                                <td colspan=4><?php echo $avon_sms['agent_rvw_note'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
                                                <td colspan=4><?php echo $avon_sms['mgnt_rvw_note'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
                                                <td colspan=4><?php echo $avon_sms['client_rvw_note'] ?></td>
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
                                                if (is_available_qa_feedback($avon_sms['entry_date'], 72) == true) { ?>
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