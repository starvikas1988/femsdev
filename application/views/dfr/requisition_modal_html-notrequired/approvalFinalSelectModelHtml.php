<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmApprovalFinalSelect" id="candidateSelectionForm" action="<?php echo base_url(); ?>dfr/candidate_final_approval" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Final Candidate Approval</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="location_id" name="location_id" value="">
                    <input type="hidden" id="org_role" name="org_role" value="">
                    <input type="hidden" id="gender" name="gender" value="">
                    <input type="hidden" id="c_status" name="c_status" value="">
                    <input type="hidden" id="brand_id" name="brand_id" value="">
                    <input type="hidden" id="role_id" name="role_id" value="">

                    <div class="row" id="prevUserInfoRow" style="display:none; margin-bottom:10px">
                        <div class="col-md-12" style="border-color: #a94442;" id="prevUserInfoContent">

                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-4 loi_check" style="display: none;">
                            <div class="form-group">
                                <input type="checkbox" name="is_loi" id="is_loi" value=""><label>&nbsp;&nbsp;Is Stipned Candidate?</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group loi_check_lbl">
                                <?php
                                if (isIndiaLocation(get_user_office_id()) == true) {
                                    echo '<label class="loi_lbl"><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Date of Joining (dd/mm/yyyy)</label>';
                                } else {
                                    echo '<label class="loi_lbl"><i class="fa fa-asterisk" style="font-size:6px; color:red"></i> &nbsp; Date of Joining (mm/dd/yyyy)</label>';
                                }
                                ?>
                                <input type="text" id="doj" name="doj" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Approval Comment<sup><i class="fa fa-asterisk" style="font-size:6px; color:red"></i></sup></label>
                                <textarea class="form-control" id="approved_comment" name="approved_comment" required style="min-height:40px;"></textarea>
                            </div>
                        </div>

                    </div>
                    <div id="check_payroll">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pay Type</label>
                                    <select class="form-control" id="pay_type" name="pay_type" required>
                                        <option value="">-Select-</option>
                                        <?php foreach ($paytype as $tokenpay) { ?>
                                            <option value="<?php echo $tokenpay['id']; ?>"><?php echo $tokenpay['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select class="form-control" id="pay_currency" name="pay_currency" required>
                                        <option value="">-Select-</option>
                                        <?php
                                        foreach ($mastercurrency as $mcr) {
                                            $getcr = '';
                                            $abbr_currency = $mcr['abbr'];
                                            if (in_array($myoffice_id, $setcurrency[$abbr_currency])) {
                                                $getcr = 'selected';
                                            } ?>
                                            <option value="<?php echo $mcr['abbr']; ?>" <?php echo $getcr; ?>><?php echo $mcr['description']; ?> (<?php echo $mcr['abbr']; ?>)</option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Incentive Period</label>
                                    <select class="form-control" id="incentive_period" name="incentive_period">
                                        <option value="">-Select-</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Yearly">Yearly</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Incentive Amount</label>
                                    <input type="number" min="0" id="incentive_amt" name="incentive_amt" class="form-control" autocomplete="off" value='0'>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Joining Bonus</label>
                                    <input type="number" min="0" id="joining_bonus" name="joining_bonus" class="form-control" autocomplete="off" value='0'>
                                </div>
                            </div>

                            <div class="col-md-4 indlocation">
                                <div class="form-group">
                                    <label>Variable Pay</label>
                                    <input type="number" min="0" step="0.01" id="variable_pay" name="variable_pay" class="form-control" autocomplete="off" value='0'>
                                </div>
                            </div>
                            <div class="col-md-4 indlocation"></div>
                            <div class="col-md-4 indlocation"></div>

                            <div class="col-md-6" class='cspl' style="display:none;">
                                <div class="form-group">
                                    <label>Skill Set for Bonus</label>
                                    <select class="form-control" id="skill_set_slab" name="skill_set_slab">
                                        <option value="0">-Select-</option>
                                        <?php foreach ($skillset_list as $skillse) { ?>
                                            <option value="<?php echo $skillse['amount']; ?>"><?php echo $skillse['skill_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6" class='cspl' style="display:none;">
                                <div class="form-group">
                                    <label>Training Fees (per day)</label>
                                    <input type="text" id="training_fees" name="training_fees" class="form-control" onkeyup="checkDec(this);" autocomplete="off" value='0'>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="grossid">
                                    <label>Monthly Total Earning (Gross Pay)</label>
                                    <input type="text" id="gross_amount" name="gross_amount" class="form-control" onkeyup="checkDec(this);" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group perday" id="" style="display: none;">
                                    <label id="perday_lbl"></label>
                                    <input type="text" id="training_ctc" class="form-control" onkeyup="checkDec(this);" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group perday" style="display: none;">
                                    <label>Training Fees (per day)</label>
                                    <input type="text" id="training_fees_perday" class="form-control" onkeyup="checkDec(this);" autocomplete="off">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row" id="stop_payroll" style="display:none;">
                        <input name="pay_type" value="0" type="hidden">
                        <input name="pay_currency" value="" type="hidden">
                        <input name="gross_amount" value="0" type="hidden">
                    </div>
                    <!-- <div id="tranee_agent" style="display:none;"><b style="color:#ff0000;">** On the training period stipened will be <?= $stipend_percent ?>% of gross salary &#8377;<span id="total_stipned"></span> per day &#8377;<span id="per_day_stipned"></span></b></div> -->
                    <div id='calcKOL' style="display:none">

                        <table cellpadding='2' cellspacing="0" border='1' style='font-size:12px; text-align:center; width:100%'>
                            <tr bgcolor="#A9A9A9">
                                <th><strong>Salary Components</strong></th>
                                <th><strong>Monthly</strong></th>
                                <th><strong>Yearly</strong></th>
                            </tr>
                            <tr>
                                <td>Basic</td>
                                <td><input type="text" id="basic" name="basic" class="form-control" readonly>
                                <td><input type="text" id="basicyr" name="basicyr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>HRA</td>
                                <td><input type="text" id="hra" name="hra" class="form-control" readonly>
                                <td><input type="text" id="hrayr" name="hrayr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Conveyance</td>
                                <td><input type="text" id="conveyance" name="conveyance" class="form-control" readonly>
                                <td><input type="text" id="conveyanceyr" name="conveyanceyr" class="form-control" readonly></td>
                            </tr>

                            <tr class='ind_oth'>
                                <td>Other Allowance</td>
                                <td><input type="text" id="allowance" name="allowance" class="form-control" readonly>
                                <td><input type="text" id="allowanceyr" name="allowanceyr" class="form-control" readonly></td>
                            </tr>

                            <tr class='cspl'>
                                <td>Medical Allowance</td>
                                <td><input type="text" id="medical_amt" name="medical_amt" class="form-control" readonly>
                                <td><input type="text" id="medical_amtyr" name="medical_amtyr" class="form-control" readonly></td>
                            </tr>

                            <tr class='cspl'>
                                <td>Statutory Bonus</td>
                                <td><input type="text" id="bonus_amt" name="bonus_amt" class="form-control" readonly>
                                <td><input type="text" id="bonus_amtyr" name="bonus_amtyr" class="form-control" readonly></td>
                            </tr>

                            <tr bgcolor="#D3D3D3">
                                <td>TOTAL EARNING (Groos Pay)</td>
                                <td><input type="text" id="tot_earning" name="tot_earning" class="form-control" readonly>
                                <td><input type="text" id="tot_earningyr" name="tot_earningyr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>PF (Employer's)</td>
                                <td><input type="text" id="pf_employers" name="pf_employers" class="form-control" readonly>
                                <td><input type="text" id="pf_employersyr" name="pf_employersyr" class="form-control" readonly></td>
                            </tr>

                            <tr>
                                <td>ESIC (Employer's)</td>
                                <td><input type="text" id="esi_employers" name="esi_employers" class="form-control" readonly>
                                <td><input type="text" id="esi_employersyr" name="esi_employersyr" class="form-control" readonly></td>
                            </tr>

                            <tr class='cspl'>
                                <td>Gratuity</td>
                                <td><input type="text" id="gratuity_employers" name="gratuity_employers" class="form-control" readonly>
                                <td><input type="text" id="gratuity_employersyr" name="gratuity_employersyr" class="form-control" readonly></td>
                            </tr>
                            <tr class='cspl'>
                                <td>Employer Labour Welfare Fund</td>
                                <td><input type="text" id="lwf_employers" name="lwf_employers" class="form-control" readonly>
                                <td><input type="text" id="lwf_employersyr" name="lwf_employersyr" class="form-control" readonly></td>
                            </tr>

                            <tr bgcolor="#D3D3D3">
                                <td>CTC</td>
                                <td><input type="text" id="ctc" name="ctc" class="form-control" readonly>
                                    <input type="hidden" id="ctcchecker" name="ctcchecker" class="form-control" readonly>
                                    <input type="hidden" id="grosschecker" name="grosschecker" class="form-control" readonly>
                                </td>
                                <td><input type="text" id="ctcyr" name="ctcyr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>P.Tax</td>
                                <td><input type="text" id="ptax" name="ptax" class="form-control" readonly>
                                <td><input type="text" id="ptaxyr" name="ptaxyr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>ESIC (Employee's)</td>
                                <td><input type="text" id="esi_employees" name="esi_employees" class="form-control" readonly>
                                <td><input type="text" id="esi_employeesyr" name="esi_employeesyr" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>PF (Employee's)</td>
                                <td><input type="text" id="pf_employees" name="pf_employees" class="form-control" readonly>
                                    <input type="hidden" id="pf_employees2" name="pf_employees2">
                                </td>
                                <td><input type="text" id="pf_employeesyr" name="pf_employeesyr" class="form-control" readonly></td>
                            </tr>

                            <tr class='cspl'>
                                <td>Employee- LWF</td>
                                <td><input type="text" id="lwf_employees" name="lwf_employees" class="form-control" readonly>
                                <td><input type="text" id="lwf_employeesyr" name="lwf_employeesyr" class="form-control" readonly></td>
                            </tr>

                            <tr bgcolor="#D3D3D3">
                                <td>Take Home</td>
                                <td><input type="text" id="tk_home" name="tk_home" class="form-control" readonly></td>
                                <td><input type="text" id="tk_homeyr" name="tk_homeyr" class="form-control" readonly></td>
                            </tr>
                        </table>
                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="button" name="finalcheck" id='finalcheck' class="btn btn-primary" value="Save">
                    <!--<input type="submit" name="submit" id='finalApproval' class="btn btn-primary" value="Save">-->
                </div>

            </form>

        </div>
    </div>
    <script>
        $("#doj").datepicker();
    </script>