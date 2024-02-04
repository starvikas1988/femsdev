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
                                        <td colspan="6" id="theader" style="font-size:30px">Avon</td>
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
                                        <td colspan="2">SLA</td>
                                        <td colspan="2"><input type="text" class="form-control" id="sla" name="data[sla]" value="<?php echo $avon['sla'] ?>" disabled></td>
                                        <td>Email Type:</td>
                                        <td><input type="text" class="form-control" name="data[email_type]" value="<?php echo $avon['email_type'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Digital/Non Digital</td>
                                        <td colspan="2"><input type="text" class="form-control" name="data[digital_non_digital]" value="<?= $avon['digital_non_digital'] ?>" disabled></td>
                                        <td>Week</td>
                                        <td><input type="text" class="form-control" name="data[week]" value="<?= $avon['week'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Audit Type:</td>
                                        <td>
                                            <select class="form-control" disabled>
                                                <option><?php echo $avon['audit_type'] ?></option>
                                            </select>
                                        </td>
                                        <td>VOC:</td>
                                        <td>
                                            <select class="form-control" disabled>
                                                <option><?php echo $avon['voc'] ?></option>
                                            </select>
                                        </td>
                                        <!--<td class="auType">Auditor Type</td>
                                        <td class="auType">
                                            <select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
                                                <option value="">-Select-</option>
                                                <option value="Master">Master</option>
                                                <option value="Regular">Regular</option>
                                            </select>
                                        </td>-->
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
                                        <td>
                                            <input type="text" disabled id="avon_earned_score" name="data[earned_score]" class="form-control avon_fatal" style="font-weight:bold" value="<?= $avon['earned_score'] ?>">
                                        </td>
                                        <td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
                                        <td><input type="text" disabled id="avon_possible_score" name="data[possible_score]" class="form-control avon_fatal" style="font-weight:bold" value="<?= $avon['possible_score'] ?>"></td>
                                        <td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
                                        <td><input type="text" disabled id="avon_overall_score" name="data[overall_score]" class="form-control avon_fatal" style="font-weight:bold" value="<?= $avon['overall_score'] ?>"></td>
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
                                            <select class="form-control avon_point" name="data[standard_greeting]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=1 <?php echo $avon['standard_greeting'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?php echo $avon['standard_greeting'] == "No" ? "selected" : ""; ?> value="No">No</option>
                                                <option avon_val=0 <?php echo $avon['standard_greeting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon['cmt1'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">Composition of Email</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[composition_email]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=3 <?= $avon["composition_email"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["composition_email"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["composition_email"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $avon['cmt2'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">Probing Question (If Applicable)</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[probing_question_if_applicable]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=3 <?= $avon["probing_question_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["probing_question_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["probing_question_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $avon['cmt3'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">Escalated the Issue (If Applicable)</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[escalated_issue_if_applicable]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["escalated_issue_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["escalated_issue_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["escalated_issue_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $avon['cmt4'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Ticket Handling (If Applicable)</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[ticket_handling_if_applicable]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["ticket_handling_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["ticket_handling_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["ticket_handling_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $avon['cmt5'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">SLA Achieved</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[sla_achieved]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["sla_achieved"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["sla_achieved"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["sla_achieved"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $avon['cmt6'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Standard Closing</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[standard_closing]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=1 <?= $avon["standard_closing"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["standard_closing"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["standard_closing"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $avon['cmt7'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Correct Template Used (If Applicable)</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[correct_template_if_applicable]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=3 <?= $avon["correct_template_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["correct_template_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["correct_template_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $avon['cmt8'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Correct Disposition</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[correct_disposition]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["correct_disposition"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["correct_disposition"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["correct_disposition"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <input type="text" name="data[cmt9]" class="form-control" value="<?php echo $avon['cmt9'] ?>" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">Request Documents (If Applicable)</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[request_documents_if_applicable]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=3 <?= $avon["request_documents_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["request_documents_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["request_documents_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $avon['cmt10'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Comprehension</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[comprehension]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=3 <?= $avon["comprehension"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["comprehension"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["comprehension"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $avon['cmt11'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Avon Security (If Applicable)</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[avon_security_if_applicable]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["avon_security_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["avon_security_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["avon_security_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $avon['cmt12'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Standard Email Subject Line</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[standard_email_sub_line]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=0 <?= $avon["standard_email_sub_line"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["standard_email_sub_line"]=="No"?"selected":""?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["standard_email_sub_line"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $avon['cmt13'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Tagging of Status</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[tagging_of_status]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["tagging_of_status"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["tagging_of_status"]=="No"?"selected":""?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["tagging_of_status"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $avon['cmt14'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3" class="eml">FTR</td>
                                        <td colspan="2">Information Shared</td>
                                        <td rowspan="3">
                                            <select class="form-control avon_point" name="data[ftr]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["ftr"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["ftr"]=="No"?"selected":""?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["ftr"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td rowspan="3" colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $avon['cmt15'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Agent Action</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Others</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" class="eml">Shared Information</td>
                                        <td colspan="2">Incomplete</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[incomplete_info_shared]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=0 <?= $avon["incomplete_info_shared"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["incomplete_info_shared"]=="No"?"selected":""?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["incomplete_info_shared"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $avon['cmt16'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Inaccurate</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[inaccurate_info_shared]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=10 <?= $avon["inaccurate_info_shared"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["inaccurate_info_shared"]=="No"?"selected":""?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["inaccurate_info_shared"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $avon['cmt17'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">Used Acknowledgement Template</td>
                                        <td>
                                            <select class="form-control" name="data[use_acknowledge_temp]" required disabled>
                                                <option value="">-Select-</option>
                                                <option <?= $avon["use_acknowledge_temp"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                <option <?= $avon["use_acknowledge_temp"]=="No"?"selected":""?> value="No">No</option>
                                                <option <?= $avon["use_acknowledge_temp"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $avon['cmt18'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">Can the agent easily reply to the sender without using the Acknowledgment Template?</td>
                                        <td>
                                            <select class="form-control" name="data[agent_easy_reply_sender]" required disabled>
                                                <option value="">-Select-</option>
                                                <option <?= $avon["agent_easy_reply_sender"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                <option <?= $avon["agent_easy_reply_sender"]=="No"?"selected":""?> value="No">No</option>
                                                <option <?= $avon["agent_easy_reply_sender"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $avon['cmt19'] ?>" disabled></td>
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
                                                <select class="form-control" id="" name="agnt_fd_acpt" required>
                                                    <option value="">--Select--</option>
                                                    <option <?php echo $avon['agnt_fd_acpt'] == 'Acceptance' ? "selected" : ""; ?> value="Acceptance">Acceptance</option>
                                                    <option <?php echo $avon['agnt_fd_acpt'] == 'Not Acceptance' ? "selected" : ""; ?> value="Not Acceptance">Not Acceptance</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan=2 style="font-size:16px">Your Review</td>
                                            <td colspan=4><textarea class="form-control" name="note" required><?php echo $avon['agent_rvw_note'] ?></textarea></td>
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