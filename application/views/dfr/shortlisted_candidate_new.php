<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<style>
    td {
        font-size: 10px;
    }

    #default-datatable th {
        font-size: 11px;
    }

    #default-datatable th {
        font-size: 11px;
    }

    .table>thead>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>th,
    .table>tbody>tr>td,
    .table>tfoot>tr>th,
    .table>tfoot>tr>td {
        padding: 3px;
    }

    .skt-table td {
        padding: 2px;
    }

    .skt-table th {
        padding: 2px;
    }

    .autosch:hover {
        background: #188ae2;
        color: #fff;
    }

    .autosch {
        background: #fbfbfb;
        padding: 10px;
        cursor: pointer;
        transition: all 0.5s ease-in-out 0s;
    }
</style>

<div class="wrap">
    <section class="app-content">
        <div class="row">

            <!-- DataTable -->
            <div class="col-md-12">
                <div class="widget">
                    <header class="widget-header">
                        <h4 class="widget-title">Shortlisted Candidate List</h4>
                    </header><!-- .widget-header -->
                    <hr class="widget-separator">

                    <div class="widget-body">

                        <?php echo form_open('', array('method' => 'get','id' => 'dynamic_search_form')) ?>

                        <input type="hidden" id="req_status" name="req_status" value=''>

                        <div class="filter-widget">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" class="form-control" id="from_date" name="from_date" value="<?=date('Y-m-01')?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" class="form-control" id="to_date" name="to_date" value="<?=date('Y-m-d', strtotime('last day of this month'))?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>

                                        <?php
                                        foreach ($company_list as $key => $value) {       
                                        ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>
                                            <?php foreach ($location_list as $loc) { ?>    
                                                <option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Select Department</label>
                                        <select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
                                            <?php
                                            foreach ($department_list as $k => $dep) {        
                                            ?>
                                                <option value="<?php echo $dep['id']; ?>"><?php echo $dep['shname']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Select Client</label>
                                        <select id="fclient_id" name="client_id[]" autocomplete="off" placeholder="Select Client" multiple>
                                            <?php
                                            foreach ($client_list as $client){
                                            ?>
                                                <option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Select Process</label>
                                        <select id="fprocess_id" name="process_id" autocomplete="off" placeholder="Select Process" class="select-box">
                                            <option value="">-- Select Process--</option>
                                            <?php
                                            foreach ($process_list as $process) {
                                            ?>
                                                <option value="<?php echo $process->id; ?>" <?php echo $cScc; ?>><?php echo $process->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3" id="requisation_div" style="display:none;">
                                    <div class="form-group">
                                        <label>Requisition</label>
                                        <select autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="Select Requisition" class="select-box">
                                            <option="">ALL</option>                                                
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" name="search" id="search" value="Search" class="submit-btn">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        </form>
                    </div>
                </div><!-- .widget -->
            </div>
            <!-- END DataTable -->
        </div><!-- .row -->

        <div class="common-top">
            <div class="row">
                <div class="col-sm-12">
                    <div class="widget">
                        <input type="hidden" name="search_click" id="search_click" value="0">
                        <input type="hidden" name="button_search_value" id="button_search_value" value="0">
                        <input type="hidden" name="data_url" id="data_url" value="<?php echo base_url('dfr_new/getShortlistedCandidateAjaxResponse'); ?>">
                            <div class="tbl-container1">
                                <div id="bg_table" class="table-responsive1 new-table tbl-fixed1">
                                    <table id="dynamic-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr class='bg-info'>
                                                <th>SL</th>
                                                <th>Requision Code</th>
                                                <th>Last Qualification</th>
                                                <th>Onboarding Type</th>
                                                <th>Candidate Name</th>
                                                <th>Gender</th>
                                                <th>Mobile</th>
                                                <th>Skill Set</th>
                                                <th>Total Exp.</th>
                                                <th>Attachment</th>
                                                <th>Status</th>
                                                <?php //if (is_access_dfr_module() == 1) {  ////ACCESS PART 
                                                ?>
                                                    <th>Action</th>
                                                <?php //} ?>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div><!-- .wrap -->
<!---------------------------------Letter of Intent---------------------------------->

<div class="modal fade" id="letter_of_intent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">

            <form class="frmLetterOfIntent" action="<?php echo base_url(); ?>dfr/loi_send" onsubmit="return finalselection()" method='POST'>

                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Letter of Intent</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="c_id" name="c_id">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Onboarding Type <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <select id="onboarding_typ" name="onboarding_typ" class="form-control">
                                    <option value="">-- Select type --</option>
                                    <option value="Regular">Regular</option>
                                    <option value="NAPS">NAPS</option>
                                    <option value="Stipend">Stipend</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="fname" id="fname" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="lname" id="lname" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Training Start Date</label>
                                <input type="text" name="training_start_date" id="training_start_date" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Stipend Amount</label>
                                <input type="text" name="stipend_amount" id="stipend_amount" class="form-control number-only-no-minus-also">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CTC Amount</label>
                                <input type="text" name="ctc_amount" id="ctc_amount" class="form-control number-only-no-minus-also">
                            </div>
                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <span style="float: left;">
                        <label>Candidate History: </label>
                        <span id="user_history">

                        </span>
                    </span>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" id='send_loi_button' class="btn btn-primary" value="Save & Send">
                </div>

            </form>

        </div>
    </div>-->
</div>
<!----------------------------------Candidate Final Approval------------------------------->

<div class="modal fade" id="approvalFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div class="modal-dialog">
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
                    <input type="hidden" id="c_status" name="c_status" value="">
                    <input type="hidden" id="org_role" name="org_role" value="">
                    <input type="hidden" id="gender" name="gender" value="">
                    <input type="hidden" id="brand_id" name="brand_id" value="">
                    <input type="hidden" id="role_id" name="role_id" value="">
                    <div class="row" id="prevUserInfoRow" style="display:none; margin-bottom:10px">
                        <div class="col-md-12" style="border:1px solid; border-color:#a94442;" id="prevUserInfoContent">

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

                                            $getcr = "";
                                            $abbr_currency = $mcr['abbr'];
                                            if (in_array($myoffice_id, $setcurrency[$abbr_currency])) {
                                                $getcr = "selected";
                                            }
                                        ?>
                                            <option value="<?php echo $mcr['abbr']; ?>" <?php echo $getcr; ?>><?php echo $mcr['description']; ?> (<?php echo $mcr['abbr']; ?>)</option>
                                        <?php } ?>
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
                    <input type="submit" name="submit" id='finalApproval' class="btn btn-primary" value="Save">
                </div>

            </form>

        </div>
    </div>-->
</div>



<div class="modal fade" id="modalfinalchecknow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelFinal">Final Confirmation</h4>
            </div>
            <div id="modalfinalchecknowbody" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="finalcheckedsubmit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</div>


<!-------------------------------Candidate Final Approval For Phillipines Start---------->


<div class="modal fade" id="approvalFinalSelectModelPhp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmApprovalFinalSelectPhp" id="candidateSelectionFormPhp" action="<?php echo base_url(); ?>dfr/candidate_final_approval_php" data-toggle="validator" method='POST'>

                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Final Candidate Approval</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="location_id" name="location_id" value="">
                    <input type="hidden" id="c_status" name="c_status" value="">
                    <input type="hidden" id="org_role" name="org_role" value="">
                    <input type="hidden" id="gender" name="gender" value="">
                    <input type="hidden" id="brand_id" name="brand_id" value="">

                    <div class="row" id="prevUserInfoRow" style="display:none; margin-bottom:10px">
                        <div class="col-md-12" style="border:1px solid; border-color:#a94442;" id="prevUserInfoContent">

                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                if (isIndiaLocation(get_user_office_id()) == true) {
                                    echo '<label>Date of Joining (dd/mm/yyyy) &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
                                } else {
                                    echo '<label>Date of Joining (mm/dd/yyyy) &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>';
                                }
                                ?>
                                <input type="date" id="doj" name="doj" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <!--    <div class="col-md-12">
                                        <div class="form-group">
                                                <label>Approval Comment</label>
                                                <textarea class="form-control" id="approved_comment" name="approved_comment" required></textarea>
                                        </div>
                                </div>-->

                    </div>

                    <div class="row" id="">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Job Level &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="job_level" name="job_level" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Division &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="division" name="division" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Immediate Supervisor &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="immediate_supervisor" name="immediate_supervisor" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coordinate with &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="coordinate_with" name="coordinate_with" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Overseas &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="overseas" name="overseas" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Currency &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <select class="form-control" id="pay_currency" name="pay_currency" disabled>
                                    <option value="SL">Philippine Peso (PHP)</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Deminimis &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="deminimis" name="deminimis" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Standard Incentive &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="standard_incentive" name="standard_incentive" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Account Premium &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="account_premium" name="account_premium" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Night Differential &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="night_differential" name="night_differential" onblur="calculate_total();" class="form-control" autocomplete="off" value='0'>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group" id="">
                                <label>Monthly Basic Salary &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="basic_salary" name="basic_salary" class="form-control" onblur="calculate_total();" onkeyup="checkDec(this);" autocomplete="off" value='0' required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" id="">
                                <label>Total &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="number" min="0" step=".01" id="total_amount" name="total_amount" class="form-control" autocomplete="off" value='0' readonly>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Qualification &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <textarea class="form-control" id="qualification" name="qualification" class="form-control" autocomplete="off" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Job Summary &nbsp;<i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <textarea class="form-control" id="job_summary" name="job_summary" class="form-control" autocomplete="off" required></textarea>
                            </div>
                        </div>

                        <div class="row" id="" style="display:none;">
                            <input name="pay_type" value="0" type="hidden">
                            <input name="pay_currency" value="" type="hidden">
                            <input name="gross_amount" value="0" type="hidden">
                        </div>


                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input type="button" name="finalcheckphp" id='finalcheckphp' class="btn btn-primary" value="Save">
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>



<div class="modal fade" id="modalfinalchecknowphp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelFinal">Final Confirmation</h4>
            </div>
            <div id="modalfinalchecknowbodyphp" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" id="finalcheckedsubmitphp" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</div>


<!-------------------------------Candidate Final Approval For Phillipines end------------>


<!----------------------------------Decline Approval------------------------------->

<div class="modal fade" id="declineFinalSelectModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmDeclineFinalSelect" action="<?php echo base_url(); ?>dfr/candidate_final_decline" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cancel Shortlisted Candidate</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="c_id" name="c_id" value="">
                    <input type="hidden" id="c_status" name="c_status" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Cancel Comment</label>
                                <textarea class="form-control" id="approved_comment" name="approved_comment" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" id='declineApproval' class="btn btn-primary" value="Save">
                </div>

            </form>

        </div>
    </div>-->
</div>


<!---------------Candidate Transfer-------------------->
<div class="modal fade" id="transferShortlistedCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">    
</div>
<!---------------Joining kit upload-------------------->
<div class="modal fade" id="upload_joining_kit_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div class="modal-dialog">
        <div class="modal-content">

            <form class="frmjoiningkit" id="frmjoiningkit" action="<?php echo base_url(); ?>base_url().'dfr/upload_joining_kit?" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Joining Kit Upload</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id" class="form-control">
                    <input type="hidden" id="c_id" name="c_id" class="form-control">
                    <input type="hidden" id="c_status" name="c_status" class="form-control">



                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Upload Joining Kit</label>
                                <input type="file" name="joining_kit_pdf" id="joining_kit_pdf" class="form-control" accept=".pdf" required="required" onChange="check_size(this)">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" class="btn btn-primary" value="Save">
                </div>

            </form>

        </div>
    </div>-->
</div>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>




<script type="text/javascript">
     /*var dataTable = $('#default-datatable').DataTable({
            "pageLength": '20',
            "lengthMenu": [
                [20, 50, 100, 150, 200, -1],
                [20, 50, 100, 150, 200, 'All'],
            ],
            "columnDefs": [
            { "searchable": false, "targets": [0,-1] },  // Disable search on first and last
            { "orderable": false, "targets": [0,-1] }    // Disable orderby on first and last         
            ],
            // 'scrollY': '60vh',
            'scrollCollapse': false,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'searching': false, // Remove default Search Control
            'ajax': {
                complete: function (data) {
                   
                },
                'url': '<?php echo base_url('dfr_new/getShortlistedCandidateAjaxResponse'); ?>',
                'data': function (data) {
                    // Read values
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var select_brand = $('#select-brand').val();
                    var office_id = $('#fdoffice_ids').val();
                    var select_department = $('#select-department').val();
                    var fclient_id = $('#fclient_id').val();
                    var fprocess_id = $('#fprocess_id').val();
                    var search_click = $('#search_click').val();
                    var req_status = $('#button_search_value').val();
                    // Append to data
                    data.from_date = from_date;
                    data.to_date = to_date;
                    data.brand = select_brand;
                    data.office_id = office_id;
                    data.department_id = select_department;
                    data.client_id = fclient_id;
                    data.process_id = fprocess_id;
                    data.searchClick = search_click;
                    data.req_status = req_status;
                }
            },
            'columns': [
                {data: 'sl'},
                {data: 'requisition_id'},
                {data: 'last_qualification'},
                {data: 'onboarding_type'},
                {data: 'fname'},
                {data: 'gender'},
                {data: 'phone'},
                {data: 'skill_set'},
                {data: 'total_work_exp'},
                {data: 'attachment'},
                {data: 'candidate_status'},
                {data: 'action'}
            ]

        });

        $('#search').click(function (e) {
            e.preventDefault();
            $('#search_click').val(1);
            dataTable.draw();
        });*/
</script>

<script type="text/javascript">
    document.querySelector("#req_no_position").addEventListener("keypress", function(evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });
</script>

<script>
    /*$(function() {  
     $('#multiselect').multiselect();
     
     $('#edurequisition_id').multiselect({
     includeSelectAllOption: true,
     enableFiltering: true,
     enableCaseInsensitiveFiltering: true,
     filterPlaceholder: 'Search for something...'
     }); 
     }); */
</script>
<script>
    $(function() {
        $('#multiselect').multiselect();

        $('#fdoffice_ids').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>
<script>
    $(function() {
        $('#multiselect').multiselect();

        $('#select-brand').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>

<script>
    $(function() {
        $('#multiselect').multiselect();

        $('#fclient_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>
<script>
    /*$(function() {  
     $('#multiselect').multiselect();
     
     $('#fprocess_id').multiselect({
     includeSelectAllOption: true,
     enableFiltering: true,
     enableCaseInsensitiveFiltering: true,
     filterPlaceholder: 'Search for something...'
     }); 
     }); */
</script>
<script>
    $(function() {
        $("#training_start_date").datepicker();
        $('#multiselect').multiselect();

        $('#select-department').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.select-box').selectize({
            sortField: 'text'
        });
    });

    function calculate_total() {
        var v_doj = $('.frmApprovalFinalSelectPhp #doj').val();
        var v_deminimis = $('#deminimis').val();
        var v_standard_incentive = $('#standard_incentive').val();
        var v_account_premium = $('#account_premium').val();
        var v_night_differential = $('#night_differential').val();
        var v_basicsalary = $('#basic_salary').val();
        if (v_deminimis == '') {
            $('#deminimis').val(0);
            v_deminimis = 0;
        }
        if (v_standard_incentive == '') {
            $('#standard_incentive').val(0);
            v_standard_incentive = 0;
        }
        if (v_account_premium == '') {
            $('#account_premium').val(0);
            v_account_premium = 0;
        }
        if (v_night_differential == '') {
            $('#night_differential').val(0);
            v_night_differential = 0;
        }
        if (v_basicsalary == '') {
            $('#basic_salary').val(0);
            v_basicsalary = 0;
        }

        //console.log(v_basicsalary)
        var v_totalamount = parseFloat(v_deminimis) + parseFloat(v_standard_incentive) + parseFloat(v_account_premium) + parseFloat(v_night_differential) + parseFloat(v_basicsalary);
        console.log('v_total' + v_totalamount);
        tot = v_totalamount.toFixed(2);
        console.log('tot' + tot);
        $('#total_amount').val(v_totalamount.toFixed(2));
    }
</script>


<!--summer note editor-->
<script>
    $(document).ready(function() {
        $('#qualification').summernote();
    });
    $(document).ready(function() {
        $('#job_summary').summernote();
    });
</script>
<script>
    $(".candidateApproval").click(function(e) {
        $('#sktPleaseWait').modal('show');
        var location = $(this).attr('location_id');
        $.post("<?= base_url() ?>dfr/get_indlocation/" + location).done(function(dat) {
            $('#sktPleaseWait').modal('hide');
            if (dat == true) {
                $(".indlocation").css("display", 'block');
            } else {
                $(".indlocation").css("display", 'none');
            }
        });

    });
</script>
