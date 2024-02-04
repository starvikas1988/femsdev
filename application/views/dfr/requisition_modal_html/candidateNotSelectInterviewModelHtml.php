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

    $(document).ready(function() {
        if (isIndiaLocation(location) == true) {
            $("#doj").datepicker({
                dateFormat: 'dd/mm/yy',
                minDate: new Date()
            });
        } else {
            $("#doj").datepicker({
                dateFormat: 'mm/dd/yy',
                minDate: new Date()
            });
        }

        $('#gross_amount, #pay_type, #skill_set_slab').on('keyup change', function() {
            //alert(11);



            var location_id = $('.frmApprovalFinalSelect #location_id').val().trim();
            var pay_type = $('.frmApprovalFinalSelect #pay_type').val().trim();
            var org_role = $('.frmApprovalFinalSelect #org_role').val().trim();
            var role_id = $('.frmApprovalFinalSelect #role_id').val().trim();
            var gender = $('.frmApprovalFinalSelect #gender').val().trim();
            var brand_id = $('.frmApprovalFinalSelect #brand_id').val().trim();
            var skill_set_slab = $('.frmApprovalFinalSelect #skill_set_slab').val().trim();

            if (skill_set_slab == "")
                skill_set_slab = 0;
            //12 - cspl
            var gr_amt = $('#gross_amount').val();
            // alert(gr_amt);
            get_stipend_data();



            if (isIndiaLocation(location_id) == true || location_id == "CHA") {


                if (pay_type == "1" || pay_type == "7" || pay_type == "8" || pay_type == "9") {
                    $('#grossid label').html('Monthly Total Earning');
                    if (gr_amt >= 1000) {

                        var bsc_per = .52;
                        var hra_per = .50;
                        var conv_per = 0;
                        var bonus_per = .0833;
                        if (org_role == 13) {
                            bsc_per = .35;
                            hra_per = .75;
                        }


                        var bsc = Math.round(gr_amt * bsc_per);
                        var hr = Math.round(bsc * hra_per);
                        var conv_amt = 1600;
                        var bonus_amt = 0;
                        var medical_amt = 0;
                        var gratuity_employers = 0;
                        var lwf_employers = 0;
                        var lwf_employees = 0;
                        if (location_id == "CHA" || brand_id == "12") {
                            // alert(brand_id + location_id);
                            bsc_per = .50;
                            hra_per = .25;
                            conv_per = .10;
                            bonus_per = .0833;
                            bsc = Math.round(gr_amt * bsc_per);
                            hr = Math.round(gr_amt * hra_per);
                            conv_amt = Math.round(gr_amt * conv_per);
                            bonus_amt = Math.round(skill_set_slab * bonus_per);
                            medical_amt = gr_amt - (bsc + hr + conv_amt + bonus_amt);
                            gratuity_employers = Math.round(bsc * .0481);
                            if (location_id == "CHA") {
                                lwf_employers = 20;
                                lwf_employees = 5;
                            }

                        }
                        //alert(bsc); 

                        $('#basic').val(bsc);
                        $('#basicyr').val(bsc * 12); // yearly calcultion
                        $('#hra').val(hr);
                        $('#hrayr').val(hr * 12); /// Year callculation
                        $('#conveyance').val(conv_amt);
                        $('#conveyanceyr').val(conv_amt * 12); // Yearly callculation
                        $('#allowance').val(gr_amt - (bsc + hr + conv_amt));
                        $('#allowanceyr').val((gr_amt - (bsc + hr + conv_amt)) * 12); // Yearly callculation

                        $('#bonus_amt').val(bonus_amt);
                        $('#bonus_amtyr').val(bonus_amt * 12); // Yearly callculation

                        $('#medical_amt').val(medical_amt);
                        $('#medical_amtyr').val(medical_amt * 12); // Yearly callculation


                        var pt = 0;
                        //kol-hwh (West bengal)
                        if ((gr_amt > 10000) && (gr_amt <= 15000))
                            pt = 110;
                        else if ((gr_amt > 15000) && (gr_amt <= 25000))
                            pt = 130;
                        else if ((gr_amt > 25000) && (gr_amt <= 40000))
                            pt = 150;
                        else if (gr_amt > 40000)
                            pt = 200;
                        if (location_id == "BLR") {
                            pt = 0;
                            if (gr_amt > 15000)
                                pt = 200;
                        } else if (location_id == "NOI") {
                            pt = 0;
                        } else if (location_id == "MUM") {
                            pt = 0;
                            gender = gender.toLowerCase();
                            if (gender == "")
                                alert("Gender Field is blank");
                            if (gender == "female") {
                                if (gr_amt >= 10001)
                                    pt = 200;
                            } else {
                                if ((gr_amt >= 7501) && (gr_amt <= 10000))
                                    pt = 200;
                                else if (gr_amt >= 10001)
                                    pt = 208;
                            }
                        } else if (location_id == "CHE") {
                            pt = 0;
                            if ((gr_amt > 3500) && (gr_amt <= 5000))
                                pt = 22.50;
                            else if ((gr_amt > 5000) && (gr_amt <= 7500))
                                pt = 52.50;
                            else if ((gr_amt > 7500) && (gr_amt <= 10000))
                                pt = 115;
                            else if ((gr_amt > 10000) && (gr_amt <= 12500))
                                pt = 171;
                            else if (gr_amt > 12500)
                                pt = 208;
                        } else if (location_id == "KOC") {

                            pt = 0;
                            if ((gr_amt >= 2000) && (gr_amt < 3000))
                                pt = 20;
                            else if ((gr_amt >= 3000) && (gr_amt < 5000))
                                pt = 30;
                            else if ((gr_amt >= 5000) && (gr_amt < 7500))
                                pt = 50;
                            else if ((gr_amt >= 7500) && (gr_amt < 10000))
                                pt = 75;
                            else if ((gr_amt >= 10000) && (gr_amt < 12500))
                                pt = 100;
                            else if ((gr_amt >= 12500) && (gr_amt < 16667))
                                pt = 125;
                            else if ((gr_amt >= 16667) && (gr_amt < 20833))
                                pt = 166;
                            else if (gr_amt >= 20833)
                                pt = 208;
                        } else if (location_id == "JMP") {

                            pt = 0;
                            if (gr_amt > 25000 && gr_amt <= 41666)
                                pt = 100;
                            else if (gr_amt > 41666 && gr_amt <= 66666)
                                pt = 150;
                            else if (gr_amt > 66666 && gr_amt <= 83333)
                                pt = 175;
                            else if (gr_amt > 83333)
                                pt = 208;
                        } else if (location_id == "CHA") {
                            //Rs. 200 (If Gross salary is greater than 45000)
                            pt = 0;
                            if (gr_amt > 45000)
                                pt = 200;
                        }


                        $('#ptax').val(pt);
                        $('#ptaxyr').val(pt * 12);
                        $('#tot_earning').val(gr_amt); // Total Earning
                        $('#tot_earningyr').val(gr_amt * 12); // Total Earning Yearly

                        if (gr_amt != '') {

                            if (location_id == "CHA" || brand_id == "12") {

                                $('.cspl').show();
                                $('.ind_oth').hide();
                            } else {

                                $('.cspl').hide();
                                $('.ind_oth').show();
                            }
                            if ($("#is_loi").is(":not(:checked)")) {
                                $('#calcKOL').show();
                            }
                        } else {

                            $('#calcKOL').hide();
                        }
                        var gr_amt_esi = Math.round(gr_amt - conv_amt);
                        //if(gr_amt<=21000) cnahge on 21/01/22 on request from both rohit
                        if (gr_amt_esi <= 21000) {
                            esi_employers = Math.round(gr_amt_esi * .0325); // ESI Employer's monthly
                            esi_employersyr = Math.round(esi_employers * 12); // ESI Employer's yearly

                            esi_employees = Math.round(gr_amt_esi * .0075); // ESI Employee's monthly
                            esi_employeesyr = Math.round(esi_employees * 12); // ESI Employee's yearly
                        } else {
                            esi_employers = 0; // ESI Employer's monthly
                            esi_employersyr = 0; // ESI Employer's yearly

                            esi_employees = 0; // ESI Employee's monthly
                            esi_employeesyr = 0; // ESI Employee's yearly
                        }

                        ///////// PF Calcu ///////////////////////
                        pf_employers = Math.round(bsc * .12); //PF Monthly
                        if (pf_employers > 1800)
                            pf_employers = 1800;
                        pf_employersyr = Math.round(pf_employers * 12); // PF Yearly	

                        pf_employees = pf_employers;
                        pf_employeesyr = pf_employersyr;
                        if (location_id == "CHA" || brand_id == "12") {

                            /*
                             if(gr_amt<=21000){
                             esi_employers = Math.round(gr_amt_esi * .0325);  
                             esi_employersyr = Math.round(esi_employers*12); 
                             
                             esi_employees = Math.round(gr_amt_esi * .0075);  
                             esi_employeesyr = Math.round(esi_employees*12); 
                             }
                             */

                            pf_employers = Math.round(bsc * .13); //PF Monthly
                            if (pf_employers > 1950)
                                pf_employers = 1950;
                            pf_employersyr = Math.round(pf_employers * 12); // PF Yearly	

                            pf_employees = Math.round(bsc * .12); //PF Monthly
                            //if(pf_employees>1950) pf_employees = 1950;
                            pf_employeesyr = Math.round(pf_employees * 12); // PF Yearly	
                        }

                        if (pay_type == "8") {
                            esi_employers = 0;
                            esi_employersyr = 0;
                            esi_employees = 0;
                            esi_employeesyr = 0;
                            pf_employers = 0;
                            pf_employersyr = 0;
                        }

                        $('#esi_employers').val(esi_employers); // esi_employers 
                        $('#esi_employersyr').val(esi_employersyr); // esi_employersyr Yearly
                        $('#esi_employees').val(esi_employees); // esi_employees 
                        $('#esi_employeesyr').val(esi_employeesyr); // esi_employeesyr Yearly

                        $('#pf_employers').val(pf_employers); // pf_employers 
                        $('#pf_employersyr').val(pf_employersyr); // pf_employersyr Yearly
                        $('#pf_employees').val(pf_employees); // pf_employees 
                        $('#pf_employeesyr').val(pf_employeesyr); // pf_employeesyr Yearly

                        $('#lwf_employers').val(lwf_employers); // pf_employees 
                        $('#lwf_employersyr').val(lwf_employers * 12); // pf_employeesyr Yearly

                        $('#lwf_employees').val(lwf_employees); // pf_employees 
                        $('#lwf_employeesyr').val(lwf_employees * 12); // pf_employeesyr Yearly

                        $('#gratuity_employers').val(gratuity_employers);
                        $('#gratuity_employersyr').val(gratuity_employers * 12); // Yearly callculation

                        //// CTC Calculation ////////////
                       
                        var ctc =Math.round(parseInt(gr_amt) + parseInt(esi_employers) + parseInt(pf_employers) + parseInt(lwf_employers) + parseInt(gratuity_employers));
                        get_stipend_data(ctc);//Fo Loi amount
                        $('#ctc').val(ctc); // pf_employers 
                        $('#ctcyr').val(ctc * 12); // pf_employersyr Yearly

                        //// Take home calculation
                        var tk_home = Math.round(gr_amt - (pt + esi_employees + pf_employees + lwf_employees));
                        $('#tk_home').val(tk_home); // Take home calculation
                        $('#tk_homeyr').val(tk_home * 12); // Take home Yearly calculation


                        $('#ctcchecker').val(ctc);
                        $('#grosschecker').val(tk_home);
                        //alert(gr_amt);
                    }

                } else if (pay_type == "6") {
                    var conv_per = 0;
                    var conv_amt = 1600;
                    if (location_id == "CHA" || brand_id == "12") {
                        conv_per = 0;
                        conv_amt = Math.round(gr_amt * conv_per);
                    }

                    var gr_amt_esi = Math.round(gr_amt - conv_amt);
                    var esi_employers = 0;
                    var esi_employees = 0;
                    ////////// ESI Calcu ////
                    if (gr_amt_esi <= 21000) {
                        esi_employers = Math.round(gr_amt_esi * .0325); // ESI Employer's monthly
                        esi_employees = Math.round(gr_amt_esi * .0075); // ESI Employee's monthly
                    }

                    var tk_home = Math.round(gr_amt - esi_employees);
                    var ctc = Math.round(parseInt(gr_amt) + parseInt(esi_employers));
                    get_stipend_data(ctc);//Fo Loi amount
                    $('#ctcchecker').val(ctc);
                    $('#grosschecker').val(tk_home);
                    $('#calcKOL').hide();
                    $('#grossid label').html('Total CTC');
                    // if (role_id == '3') {
                    // $("#total_stipned").html(total_stipned);



                    // } else {
                    //     $("#tranee_agent").css('display', 'none');
                    // } 
                } else {
                    get_stipend_data(gr_amt);
                    $('#ctcchecker').val(gr_amt);
                    $('#grosschecker').val(gr_amt);
                    $('#calcKOL').hide();

                    if ((pay_type == "2") || (pay_type == "3"))
                        $('#grossid label').html('Hourly Earning');
                    else if (pay_type == "11")
                        $('#grossid label').html('Per Day Earning');
                    else
                        $('#grossid label').html('Total CTC');
                }

            } else {

                // $('#+++++++++').val(gr_amt);
                $('#ctcchecker').val(gr_amt);
                $('#grosschecker').val(gr_amt);
                $('#calcKOL').hide();
                $("#tranee_agent").css('display', 'none');
                if ((pay_type == "2") || (pay_type == "3"))
                    $('#grossid label').html('Hourly Earning');
                else if (pay_type == "11")
                    $('#grossid label').html('Per Day Earning');
                else
                    $('#grossid label').html('Total CTC');
            }


        });
    });
    </script>