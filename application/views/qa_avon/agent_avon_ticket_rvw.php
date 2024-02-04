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
                                        <td>Date of Ticket:</td>
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
                                        <td colspan="2">SLA:</td>
                                        <td colspan="2"><input type="text" class="form-control" id="sla" name="data[sla]" value="<?php echo $avon['sla'] ?>" required disabled></td>
                                        <td>Ticket Type:</td>
                                        <td><input type="text" class="form-control" name="data[ticket_type]" value="<?php echo $avon['ticket_type'] ?>" disabled required></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Digital/Non Digital</td>
                                        <td colspan="2"><input type="text" class="form-control" name="data[digital_non_digital]" value="<?= $avon['digital_non_digital'] ?>" disabled></td>
                                        <td>Week</td>
                                        <td><input type="text" class="form-control" name="data[week]" value="<?= $avon['week'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Audit Type:</td>
                                        <td colspan="2">
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
                                        <td class="eml" colspan="3">Identifying Ticket</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[identifying_ticket]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon['identifying_ticket'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon['identifying_ticket'] == "No" ? "selected" : ""; ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon['identifying_ticket'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon['cmt1'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">SLA Achieved</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[sla_achieved]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["sla_achieved"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["sla_achieved"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["sla_achieved"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $avon['cmt2'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">Sent to Right Approver</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[sent_right_approver]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["sent_right_approver"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["sent_right_approver"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["sent_right_approver"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $avon['cmt3'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">Followed Request</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[followed_request]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=3 <?= $avon["followed_request"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["followed_request"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["followed_request"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $avon['cmt4'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Efficiency Of Action</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[efficiency_of_action]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["efficiency_of_action"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["efficiency_of_action"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["efficiency_of_action"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $avon['cmt5'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Correct Information Shared</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[correct_info_shared]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["correct_info_shared"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["correct_info_shared"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["correct_info_shared"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $avon['cmt6'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" colspan="3">Documentation</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[documentation]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=5 <?= $avon["documentation"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["documentation"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["documentation"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $avon['cmt7'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td class="eml" rowspan="2">Information Shared</td>
                                        <td colspan="2">Incomplete Information</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[information_shared_incomplete]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=10 <?= $avon["information_shared_incomplete"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["information_shared_incomplete"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["information_shared_incomplete"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $avon['cmt8'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Inaccurate Information</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[information_shared_inaccurate]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=10 <?= $avon["information_shared_inaccurate"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["information_shared_inaccurate"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["information_shared_inaccurate"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $avon['cmt9'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Correct Tagging</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[correct_tagging]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=10 <?= $avon["correct_tagging"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["correct_tagging"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["correct_tagging"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $avon['cmt10'] ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="eml">Avon Security</td>
                                        <td>
                                            <select class="form-control avon_point" name="data[avon_security]" required disabled>
                                                <option value="">-Select-</option>
                                                <option avon_val=10 <?= $avon["avon_security"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                <option avon_val=0 <?= $avon["avon_security"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                <option avon_val=0 <?= $avon["avon_security"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $avon['cmt11'] ?>" disabled></td>
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