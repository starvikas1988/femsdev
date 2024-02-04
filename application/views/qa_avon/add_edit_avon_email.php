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
                                            if ($avon_email['entry_by'] != '') {
                                                $auditorName = $avon_email['auditor_name'];
                                            } else {
                                                $auditorName = $avon_email['client_name'];
                                            }
                                            $auditDate = mysql2mmddyy($avon_email['audit_date']);
                                            $clDate_val = mysql2mmddyy($avon_email['call_date']);
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
                                                    <option value="<?php echo $avon_email['agent_id'] ?>"><?php echo $avon_email['fname'] . " " . $avon_email['lname'] ?></option>
                                                    <option value="">-Select-</option>
                                                    <?php foreach ($agentName as $row) :  ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>Employee ID:</td>
                                            <td><input type="text" class="form-control" id="fusion_id" value="<?php echo $avon_email['fusion_id'] ?>" readonly></td>
                                            <td>L1 Supervisor:</td>
                                            <td>
                                                <select class="form-control" id="tl_id" name="data[tl_id]" readonly>
                                                    <option value="<?php echo $avon_email['tl_id'] ?>"><?php echo $avon_email['tl_name'] ?></option>
                                                    <option value="">--Select--</option>
                                                    <?php foreach ($tlname as $tl) : ?>
                                                        <option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname'] . " " . $tl['lname']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">SLA</td>
                                            <td colspan="2"><input type="text" class="form-control" id="sla" name="data[sla]" value="<?php echo $avon_email['sla'] ?>" required></td>
                                            <td>Email Type:</td>
                                            <td>
                                                <select class="form-control" name="data[email_type]" required>
                                                    <?php if($avon_email['email_type']){ ?>
                                                    <option value="<?php echo $avon_email['email_type'] ?>"><?php echo $avon_email['email_type'] ?></option>
                                                <?php } ?>
                                                    <option value="">-SELECT-</option>
                                                    <option value="Available CL" <?= ($avon_email['email_type']=="Available CL")?"selected":"" ?>>Available CL</option>
                                                    <option value="Cannot log in" <?= ($avon_email['email_type']=="Cannot log in")?"selected":""?>>Cannot log in</option>
                                                    <option value="Avon Shop Related Concern" <?= ($avon_email['email_type']=="Avon Shop Related Concern")?"selected":""?>>Avon Shop Related Concern</option>
                                                    <option value="Branch Contact Details" <?= ($avon_email['email_type']=="Branch Contact Details")?"selected":""?>>Branch Contact Details</option>
                                                    <option value="Branch Contact Number" <?= ($avon_email['email_type']=="Branch Contact Number")?"selected":""?>>Branch Contact Number</option>
                                                    <option value="Branch Store Hours" <?= ($avon_email['email_type']=="Branch Store Hours")?"selected":""?>>Branch Store Hours</option>
                                                    <option value="Branch Transfer" <?= ($avon_email['email_type']=="Branch Transfer")?"selected":""?>>Branch Transfer</option>
                                                    <option value="Cancel Order" <?= ($avon_email['email_type']=="Cancel Order")?"selected":""?>>Cancel Order</option>
                                                    <option value="Cannot Access AE Link" <?= ($avon_email['email_type']=="Cannot Access AE Link")?"selected":""?>>Cannot Access AE Link</option>
                                                    <option value="Cannot Order - 24 hour rule" <?= ($avon_email['email_type']=="Cannot Order - 24 hour rule")?"selected":""?>>Cannot Order - 24 hour rule</option>
                                                    <option value="Copy of Invoice" <?= ($avon_email['email_type']=="Copy of Invoice")?"selected":""?>>Copy Of Invoice</option>
                                                    <option value="Credit Line Increase" <?= ($avon_email['email_type']=="Credit Line Increase")?"selected":""?>>Credit Line Increase</option>
                                                    <option value="Credit Line Initial Granting" <?= ($avon_email['email_type']=="Credit Line Initial Granting")?"selected":""?>>Credit Line Initial Granting</option>
                                                    <option value="Defective Item for return or exchange" <?= ($avon_email['email_type']=="Defective Item for return or exchange")?>>Defective Item for return or exchange</option>
                                                    <option value="Delivery Coverage" <?= ($avon_email['email_type']=="Delivery Coverage")?"selected":""?>>Delivery Coverage</option>
                                                    <option value="Discontinued/Removed FD for Resign" <?= ($avon_email['email_type']=="Discontinued/Removed FD for Resign")?"selected":""?>>Discontinued/Removed FD for Resign</option>
													<option value="Discount not reflected in the Invoice" <?= ($avon_email['email_type']=="Discount not reflected in the Invoice")?"selected":""?>>Discount not reflected in the Invoice</option>
													<option value="Due Date" <?= ($avon_email['email_type']=="Due Date")?"selected":""?>>Due Date</option>
													<option value="Feedback" <?= ($avon_email['email_type']=="Feedback")?"selected":""?>>Feedback</option>
													<option value="Follow Up CRM" <?= ($avon_email['email_type']=="Follow Up CRM")?"selected":""?>>Follow Up CRM</option>
													<option value="How it works" <?= ($avon_email['email_type']=="How it works")?"selected":""?>>How it works</option>
													<option value="How to pay due amount" <?= ($avon_email['email_type']=="How to pay due amount")?"selected":""?>>How to pay due amount</option>
													<option value="How to purchase" <?= ($avon_email['email_type']=="How to purchase")?"selected":""?>>How to purchase</option>
													<option value="Incomplete Delivery" <?= ($avon_email['email_type']=="Incomplete Delivery")?"selected":""?>>Incomplete Delivery</option>
													<option value="Incorrect Delivery" <?= ($avon_email['email_type']=="Incorrect Delivery")?"selected":""?>>Incorrect Delivery</option>
													<option value="Inquiry Ticket" <?= ($avon_email['email_type']=="Inquiry Ticket")?"selected":""?>>Inquiry Ticket</option>
													<option value="No Delivery Yet" <?= ($avon_email['email_type']=="No Delivery Yet")?"selected":""?>>No Delivery Yet</option>
													<option value="Online Order Status" <?= ($avon_email['email_type']=="Online Order Status")?"selected":""?>>Online Order Status</option>
													<option value="Order Impersonation" <?= ($avon_email['email_type']=="Order Impersonation")?"selected":""?>>Order Impersonation</option>
													<option value="PDA" <?= ($avon_email['email_type']=="PDA")?"selected":""?>>PDA</option>
													<option value="POP Payment not posted" <?= ($avon_email['email_type']=="POP Payment not posted")?"selected":""?>>POP Payment not posted</option>
													<option value="Product Quality Feedback" <?= ($avon_email['email_type']=="Product Quality Feedback")?"selected":""?>>Product Quality Feedback</option>
													<option value="Proof of Payment Submitted" <?= ($avon_email['email_type']=="Proof of Payment Submitted")?"selected":""?>>Proof of Payment Submitted</option>
													<option value="Registration" <?= ($avon_email['email_type']=="Registration")?"selected":""?>>Registration</option>
													<option value="Registration Status" <?= ($avon_email['email_type']=="Registration Status")?"selected":""?>>Registration Status</option>
													<option value="Rep Account Inquiry - AREP" <?= ($avon_email['email_type']=="Rep Account Inquiry - AREP")?"selected":""?>>Rep Account Inquiry - AREP</option>
													<option value="REP Account Status" <?= ($avon_email['email_type']=="REP Account Status")?"selected":""?>>REP Account Status</option>
													<option value="REP Reinstatement" <?= ($avon_email['email_type']=="REP Reinstatement")?"selected":""?>>REP Reinstatement</option>
													<option value="Request for RA for Current SF payout" <?= ($avon_email['email_type']=="Request for RA for Current SF payout")?"selected":""?>>Request for RA for Current SF payout</option>
													<option value="Request for RA for Previous SF payout" <?= ($avon_email['email_type']=="Request for RA for Previous SF payout")?"selected":""?>>Request for RA for Previous SF payout</option>
													<option value="Request Ticket" <?= ($avon_email['email_type']=="Request Ticket")?"selected":""?>>Request Ticket</option>
													<option value="Request to Change or Update Info" <?= ($avon_email['email_type']=="Request to Change or Update Info")?"selected":""?>>Request to Change or Update Info</option>
													<option value="Request to Update or Change Info" <?= ($avon_email['email_type']=="Request to Update or Change Info")?"selected":""?>>Request to Update or Change Info</option>
													<option value="Solicitation or Marketing Offer" <?= ($avon_email['email_type']=="Solicitation or Marketing Offer")?"selected":""?>>Solicitation or Marketing Offer</option>
													<option value="Stock Availability" <?= ($avon_email['email_type']=="Stock Availability")?"selected":""?>>Stock Availability</option>
													<option value="Undelivered Order reflected on FD due" <?= ($avon_email['email_type']=="Undelivered Order reflected on FD due")?"selected":""?>>Undelivered Order reflected on FD due</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Digital/Non Digital</td>
                                            <td colspan="2">
                                                <select class="form-control" name="data[digital_non_digital]" required>
                                                    <option value="Yes" <?= ($avon_email['digital_non_digital']=="Yes")?"selected":""?>>Yes</option>
                                                    <option value="No" <?= ($avon_email['digital_non_digital']=="No")?"selected":""?>>No</option>
                                                </select>
                                            </td>
                                            <td>Week</td>
                                            <td>
                                                <select class="form-control" name="data[week]" required>
                                                    <option value="1" <?= ($avon_email['week']=="1")?"selected":""?>>Week 1</option>
                                                    <option value="2" <?= ($avon_email['week']=="2")?"selected":""?>>Week 2</option>
                                                    <option value="3" <?= ($avon_email['week']=="3")?"selected":""?>>Week 3</option>
                                                    <option value="4" <?= ($avon_email['week']=="4")?"selected":""?>>Week 4</option>
                                                    <option value="5" <?= ($avon_email['week']=="5")?"selected":""?>>Week 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Audit Type:</td>
                                            <td>
                                                <select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($avon_email['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($avon_email['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($avon_email['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($avon_email['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($avon_email['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($avon_email['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($avon_email['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
                                            </td>
                                            <td class="auType">Auditor Type</td>
                                            <td class="auType">
                                                <select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">-Select-</option>
                                                    <option value="Master" <?= ($avon_email['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($avon_email['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
                                            </td>
                                            <td>VOC:</td>
                                            <td>
                                                <select class="form-control" id="voc" name="data[voc]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="1" <?= ($avon_email['voc']=="1")?"selected":"" ?>>1</option>
                                                    <option value="2" <?= ($avon_email['voc']=="2")?"selected":"" ?>>2</option>
                                                    <option value="3" <?= ($avon_email['voc']=="3")?"selected":"" ?>>3</option>
                                                    <option value="4" <?= ($avon_email['voc']=="4")?"selected":"" ?>>4</option>
                                                    <option value="5" <?= ($avon_email['voc']=="5")?"selected":"" ?>>5</option>
                                                    <option value="6" <?= ($avon_email['voc']=="6")?"selected":"" ?>>6</option>
                                                    <option value="7" <?= ($avon_email['voc']=="7")?"selected":"" ?>>7</option>
                                                    <option value="8" <?= ($avon_email['voc']=="8")?"selected":"" ?>>8</option>
                                                    <option value="9" <?= ($avon_email['voc']=="9")?"selected":"" ?>>9</option>
                                                    <option value="10" <?= ($avon_email['voc']=="10")?"selected":"" ?>>10</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
                                            <td><input type="text" readonly id="avon_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $avon_email['earned_score'] ?>" /></td>
                                            <td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
                                            <td><input type="text" readonly id="avon_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $avon_email['possible_score'] ?>" /></td>
                                            <td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
                                            <td><input type="text" readonly id="avon_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $avon_email['overall_score'] ?>"></td>
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
                                                    <option avon_val=1 <?php echo $avon_email['standard_greeting'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?php echo $avon_email['standard_greeting'] == "No" ? "selected" : ""; ?> value="No">No</option>
                                                    <option avon_val=0 <?php echo $avon_email['standard_greeting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon_email['cmt1'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Composition of Email</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[composition_email]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_email["composition_email"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["composition_email"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["composition_email"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $avon_email['cmt2'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Probing Question (If Applicable)</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[probing_question_if_applicable]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_email["probing_question_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["probing_question_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["probing_question_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $avon_email['cmt3'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Escalated the Issue (If Applicable)</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[escalated_issue_if_applicable]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=5 <?= $avon_email["escalated_issue_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["escalated_issue_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["escalated_issue_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $avon_email['cmt4'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Ticket Handling (If Applicable)</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[ticket_handling_if_applicable]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=5 <?= $avon_email["ticket_handling_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["ticket_handling_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["ticket_handling_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $avon_email['cmt5'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">SLA Achieved</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[sla_achieved]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=5 <?= $avon_email["sla_achieved"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["sla_achieved"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["sla_achieved"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $avon_email['cmt6'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Standard Closing</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[standard_closing]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=1 <?= $avon_email["standard_closing"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["standard_closing"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["standard_closing"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $avon_email['cmt7'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Correct Template Used (If Applicable)</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[correct_template_if_applicable]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_email["correct_template_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["correct_template_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["correct_template_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $avon_email['cmt8'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Correct Disposition</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[correct_disposition]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=5 <?= $avon_email["correct_disposition"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["correct_disposition"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["correct_disposition"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan="2">
                                                <input type="text" name="data[cmt9]" class="form-control" value="<?php echo $avon_email['cmt9'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Request Documents (If Applicable)</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[request_documents_if_applicable]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_email["request_documents_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["request_documents_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["request_documents_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $avon_email['cmt10'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Comprehension</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[comprehension]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=3 <?= $avon_email["comprehension"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["comprehension"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["comprehension"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $avon_email['cmt11'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Avon Security (If Applicable)</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[avon_security_if_applicable]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=5 <?= $avon_email["avon_security_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["avon_security_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["avon_security_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $avon_email['cmt12'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Standard Email Subject Line</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[standard_email_sub_line]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=0 <?= $avon_email["standard_email_sub_line"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["standard_email_sub_line"]=="No"?"selected":""?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["standard_email_sub_line"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $avon_email['cmt13'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="eml">Tagging of Status</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[tagging_of_status]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=5 <?= $avon_email["tagging_of_status"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["tagging_of_status"]=="No"?"selected":""?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["tagging_of_status"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $avon_email['cmt14'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3" class="eml">FTR</td>
                                            <td colspan="2">Information Shared</td>
                                            <td rowspan="3">
                                                <select class="form-control avon_point" name="data[ftr]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=5 <?= $avon_email["ftr"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["ftr"]=="No"?"selected":""?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["ftr"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td rowspan="3" colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $avon_email['cmt15'] ?>"></td>
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
                                                <select class="form-control avon_point" name="data[incomplete_info_shared]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=0 <?= $avon_email["incomplete_info_shared"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["incomplete_info_shared"]=="No"?"selected":""?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["incomplete_info_shared"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $avon_email['cmt16'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Inaccurate</td>
                                            <td>
                                                <select class="form-control avon_point" name="data[inaccurate_info_shared]" required>
                                                    <option value="">-Select-</option>
                                                    <option avon_val=10 <?= $avon_email["inaccurate_info_shared"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                    <option avon_val=0 <?= $avon_email["inaccurate_info_shared"]=="No"?"selected":""?> value="No">No</option>
                                                    <option avon_val=0 <?= $avon_email["inaccurate_info_shared"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $avon_email['cmt17'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Used Acknowledgement Template</td>
                                            <td>
                                                <select class="form-control" name="data[use_acknowledge_temp]" required>
                                                    <option value="">-Select-</option>
                                                    <option <?= $avon_email["use_acknowledge_temp"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                    <option <?= $avon_email["use_acknowledge_temp"]=="No"?"selected":""?> value="No">No</option>
                                                    <option <?= $avon_email["use_acknowledge_temp"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $avon_email['cmt18'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="eml" colspan="3">Can the agent easily reply to the sender without using the Acknowledgment Template?</td>
                                            <td>
                                                <select class="form-control" name="data[agent_easy_reply_sender]" required>
                                                    <option value="">-Select-</option>
                                                    <option <?= $avon_email["agent_easy_reply_sender"]=="Yes"?"selected":""?> value="Yes">Yes</option>
                                                    <option <?= $avon_email["agent_easy_reply_sender"]=="No"?"selected":""?> value="No">No</option>
                                                    <option <?= $avon_email["agent_easy_reply_sender"]=="N/A"?"selected":""?> value="N/A">N/A</option>
                                                </select>
                                            </td>
                                            <td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $avon_email['cmt19'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Call Summary:</td>
                                            <td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $avon_email['call_summary'] ?></textarea></td>
                                            <td>Feedback:</td>
                                            <td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $avon_email['feedback'] ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan=2>Upload Files</td>
                                            <?php if ($avon_id == 0) { ?>
                                                <td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
                                                <?php } else {
                                                if ($avon_email['attach_file'] != '') { ?>
                                                    <td colspan=4>
                                                        <?php $attach_file = explode(",", $avon_email['attach_file']);
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
                                                <td colspan=4><?php echo $avon_email['agnt_fd_acpt'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
                                                <td colspan=4><?php echo $avon_email['agent_rvw_note'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
                                                <td colspan=4><?php echo $avon_email['mgnt_rvw_note'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
                                                <td colspan=4><?php echo $avon_email['client_rvw_note'] ?></td>
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
                                                if (is_available_qa_feedback($avon_email['entry_date'], 72) == true) { ?>
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