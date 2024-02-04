<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<style>
    .table>thead>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>th,
    .table>tbody>tr>td,
    .table>tfoot>tr>th,
    .table>tfoot>tr>td {
        padding: 2px;
        text-align: center;
    }

    .btn {
        /*min-width:105px;*/
    }

    .label {
        /*padding: .7em .6em;*/
    }

    #req_qualification_container {
        display: none;
    }

    /*start custom design css here*/
    .small-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        padding: 0;
        margin: 0 0 0 2px;
        line-height: 19px;
    }

    .red-btn {
        width: 100px;
        padding: 10px;
        background: #f00;
        color: #fff;
        font-size: 13px;
        letter-spacing: 0.5px;
        transition: all 0.5s ease-in-out 0s;
        border: none;
        border-radius: 5px;
    }

    .red-btn:hover {
        background: #af0606;
        color: #fff;
    }

    .candidate-area {
        width: 100%;
    }

    .candidate-area label {
        margin: 10px 0 0 0;
    }

    .cloumns-bg {
        background: #eee;
        padding: 10px;
    }

    .cloumns-bg1 {
        background: #f5f5f5;
        padding: 10px;
    }

    .no-padding {
        padding: 0;
        margin: 0;
    }

    .table-small {
        height: 400px;
        overflow: scroll;
    }

    /*end custom design css here*/
    .btn-mul .btn-group {
        width: 100%;
    }

    .filter-widget .multiselect-container {
        width: 100%;
    }

     
        .new-table .col-sm-12 {
            overflow-x: scroll;
        }
        .wrap {
            margin: 10px 20px 10px 10px;
        }
    .dataTables_paginate{
        margin: 0 90px 0 0!important;
    }
</style>
<div class="wrap">
    <section class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="row">
                        <div class="col-md-4">
                            <header class="widget-header">                               
                                <h4 class="widget-title">Manage <span style="font-weight:bold; font-size:18px"><?php //echo $req_Status;       ?></span> Requisition</h4>
                            </header>
                        </div>
                        <div class="col-md-8" style='float:right; padding-right:10px; margin-top:14px'>
                            <div class="form-group" style='padding-right:10px; float:right'>
                                <a href='javascript:void(0);' data-val="2" class="button_search_option">  <span style="padding:8px 12px;border-radius:5px;font-size:13px;" class="label label-warning">Cancel/Decline</span></a>
                            </div>
                            <div class="form-group" style='padding-right:10px; float:right'>
                                <a href='javascript:void(0);' data-val="1" class="button_search_option">  <span style="padding:8px 12px;border-radius:5px;font-size:13px;" class="label label-danger">Closed</span></a>
                            </div>
                            <div class="form-group" style='padding-right:10px; float:right'>
                                <a href='javascript:void(0);' data-val="3" class="button_search_option">  <span style="padding:8px 12px;border-radius:5px;font-size:13px;" class="label label-info">Pending</span></a>
                            </div>
                            <div class="form-group" style='padding-right:10px; float:right'>
                                <a href='javascript:void(0);' data-val="0" class="button_search_option"> <span style="padding:8px 12px;border-radius:5px;font-size:13px;" class="label label-success">Open</span></a>                                
                            </div>
                        </div>
                    </div>
                    <hr class="widget-separator">
                    <div class="widget-body">
                        <?php echo form_open('', array('method' => 'get','id' => 'dynamic_search_form')) ?>
                        <input type="hidden" id="req_status" name="req_status" value=''>
                        <div class="filter-widget">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" class="form-control" id="from_date" name="from_date" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" class="form-control" id="to_date" name="to_date" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>
                                            <?php
                                            foreach ($company_list as $key => $value) {
                                                $bss = "";
                                                // if (in_array($value['id'], $brand))
                                                //     $bss = "selected";
                                                ?>
                                                <option value="<?php echo $value['id']; ?>" <?php echo $bss; ?>><?php echo $value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>                                           
                                            <?php foreach ($location_list as $loc) : ?>
                                                <?php
                                                $sCss = "";
                                                // if (in_array($loc['abbr'], $oValue))
                                                //     $sCss = "selected";
                                                ?>
                                                <option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>
                                            <?php endforeach; ?>
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
                                                $sCss = "";
                                                // if (in_array($dep['id'], $o_department_id))
                                                //     $sCss = "selected";
                                                ?>
                                                <option value="<?php echo $dep['id']; ?>" <?php echo $sCss; ?>><?php echo $dep['shname']; ?></option>
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
                                            foreach ($client_list as $client) :
                                                $cScc = '';
                                                // if (in_array($client->id, $client_id))
                                                //     $cScc = 'Selected';
                                                ?>
                                                <option value="<?php echo $client->id; ?>" <?php echo $cScc; ?>><?php echo $client->shname; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Select Process</label>
                                        <select id="fprocess_id" name="process_id" autocomplete="off" placeholder="Select Process" class="select-box">
                                            <option value="">-- Select Process--</option>
                                            <?php
                                            foreach ($process_list as $process) :
                                                $cScc = '';
                                                // if ($process->id == $process_id)
                                                //     $cScc = 'Selected';
                                                ?>
                                                <option value="<?php echo $process->id; ?>" <?php echo $cScc; ?>><?php echo $process->name; ?></option>
                                            <?php endforeach; ?>
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
                </div>
            </div>
        </div>

        <div class="common-top">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="row">
                                <?php
                                if ((get_dept_folder() == "wfm" || get_global_access() == 1 || $is_role_dir == "admin" || $is_role_dir == "manager" || is_access_dfr_module() == true || is_approve_requisition() == true) && (get_user_fusion_id() != "FCHA002023" && get_user_fusion_id() != "FCHA003524" && get_user_fusion_id() != "FCHA002279" && get_user_fusion_id() != "FCHA005440")) {
                                    ?>
                                    <div class="col-md-12" style="float:right">
                                        <div class="form-group" style='float:right; display: inline-block;padding: 15px 15px 5px 0;border-radius:5px;cursor:pointer;font-size:16px;position: absolute;right: 0;top: -12px;z-index: 1;'>
                                            <a><span style="padding:10px;" class="label label-primary addRequisition">Add Requisition</span></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                            <input type="hidden" name="search_click" id="search_click" value="0">
                            <input type="hidden" name="button_search_value" id="button_search_value" value="0">
                            <input type="hidden" name="data_url" id="data_url" value="<?php echo base_url('dfr_new/getRequisitionAjaxResponse'); ?>">
                            <div class="tbl-container1">
                            <div id="bg_table" class="table-responsive1 new-table tbl-fixed1">
                                <table id="dynamic-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class='bg-info'>
                                            <th>SL</th>
                                            <th>Requisition Code</th>
                                            <th>Type</th>
                                            <th>Company Brand</th>
                                            <th>Department</th>
                                            <th>Due Date</th>
                                            <th id="chs_show">Proposed Date</th>
                                            <?php /* if ($oValue == 'CHA') { ?>
                                              <th>Proposed Date</th>
                                              <?php } */ ?>
                                            <th>Position</th>
                                            <th>Client</th>
                                            <th>Process</th>
                                            <th>Required Position</th>
                                            <th>Filled Position</th>
                                            <th>Total Candidate(count)</th>
                                            <th>Total Shortlisted(count)</th>
                                            <th>Batch No</th>
                                            <th>Raised By</th>
                                            <th>Raised Date</th>
                                            <th>Approved By</th>
                                            <th>Approved Date</th>
                                            <th>Trainer/L1 Supervisor</th>
                                            <th>Closed Date</th>
                                            <th>Closed Comment</th>
                                            <th>Action</th>
                                            <?php /* if ($req_status == 1) { ?>
                                              <th>Closed Comment</th>
                                              <?php } */ ?>
                                            <?php /* if ($req_status != 2) { ?>
                                              <th>Action</th>
                                              <?php } */ ?>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!---------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------->

<!----------- Add Requisition model ------------>
<div class="modal fade modal-design" id="addRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form class="frmAddRequisition" action="<?php echo base_url(); ?>dfr/add_requisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add New Requisition</h4>
                </div>
                <div class="modal-body">
                    <div class="filter-widget">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Location</label>
                                    <select class="select-box" name="location" id="location" required>
                                        <option value="">--Select--</option>
                                        <?php
                                        foreach ($location_list as $ld) : $abb = $ld['abbr'];
                                            if (get_user_fusion_id() == "FCHA000263") {
                                                if ($abb == "CHA") {
                                                    ?>
                                                    <option value="<?php echo $ld['abbr']; ?>"><?php echo $ld['office_name']; ?></option>
                                                    <?php
                                                } else {
                                                    echo "";
                                                }
                                            } else {
                                                ?><option value="<?php echo $ld['abbr']; ?>"><?php echo $ld['office_name']; ?></option><?php
                                            }
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="select-box" id="department_id" name="department_id" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($department_data as $row) : ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['shname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Requisition Type</label>
                                    <select class="select-box" id="req_type" name="req_type" required>
                                        <option value="">--Select--</option>
                                        <option value="Growth">Growth</option>
                                        <option value="Attrition">Attrition</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Due Date</label>
                                    <input type="text" id="due_date" name="due_date" class="form-control" disabled>
                                </div>
                            </div>

                            <div class="col-md-4" id='proposed_date_add_col' style='display:none;'>
                                <div class="form-group">
                                    <label>Proposed New Date</label>
                                    <input type="text" id="proposed_date_add" name="proposed_date" class="form-control" readonly="readonly">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Company Brand</label>
                                    <select id="company_brand" name="company_brand" class="select-box brand" required>
                                        <option value="">-- Select Brand --</option>
                                        <?php
                                        foreach ($company_list as $key => $value) {
                                            if (get_user_fusion_id() == "FCHA000263") {
                                                if ($value['name'] == "CSPL") {
                                                    ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                    <?php
                                                } else {
                                                    echo "";
                                                }
                                            } else {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Position</label>
                                    <select class="select-box" id="role_id" name="role_id" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($role_data as $row1) : ?>
                                            <option value="<?php echo $row1->id; ?>"><?php echo $row1->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="select-box" id="fdclient_id" name="client_id" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($client_list as $client) : ?>
                                            <option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Process</label>
                                    <select class="select-box" id="fdprocess_id" name="process_id" required>
                                        <option value="">--Select--</option>
                                        <?php foreach ($process_list as $process) : ?>
                                            <option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Required no of Position</label>
                                    <input type="number" id="req_no_position" name="req_no_position" class="form-control" value="" placeholder="Enter Req. no of Position..." required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Batch No</label>
                                    <input type="text" id="job_title" name="job_title" class="form-control" value="" placeholder="Enter Batch No...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Required Skill</label>
                                    <input type="text" id="req_skill" name="req_skill" class="form-control" value="" placeholder="Enter Required Skill..." required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Is Asset Required?</label>
                                    <select class="select-box" id="is_asset" name="is_asset" required>
                                        <option value="">--Select--</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 asset_required" style="display:none;">
                                <div class="form-group btn-mul">
                                    <label>Asset Requirements</label><br>
                                    <select id="asset_requisition" name="asset_requisition[]" autocomplete="off1" placeholder="Select Assets" multiple>
                                        <?php
                                        if (!empty($asset_list)) {
                                            foreach ($asset_list as $list) {
                                                ?>
                                                <option value="<?= $list['id'] ?>"><?= $list['name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Work Type</label>
                                    <select class="select-box" id="work_type" name="work_type" required>
                                        <option value="">--Select--</option>
                                        <option value="1">WFO</option>
                                        <option value="2">WFH</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row assets_count" style="display:none;"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Employee Status</label>
                                    <select class="select-box" id="employee_status" name="employee_status">
                                        <option value="">--Select--</option>
                                        <option value="1">Part Time</option>
                                        <option value="2">Full Time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Qualification</label>
                                    <select class="select-box" id="qualification_type" name="a" required>
                                        <option value="">--Select--</option>
                                        <option value="Xth">Xth</option>
                                        <option value="XII">XII</option>
                                        <option value="Graduation">Graduation</option>
                                        <option value="Masters">Masters</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" id="req_qualification_container">
                                <div class="form-group">
                                    <label>;</label>
                                    <input type="text" id="req_qualification" name="req_qualification" class="form-control" value="" placeholder="Req. Qualification..." required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Required Experience Range (In Year)</label>
                                    <input type="number" maxlength="4" id="req_exp_range" name="req_exp_range" class="form-control" value="" placeholder="Enter Req. Exp. Range..." required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Job Description</label>
                                    <textarea class="form-control" id="job_desc" name="job_desc"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Additional Information</label>
                                    <textarea class="form-control" id="additional_info" name="additional_info"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="site_cspl" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Site</label>
                                        <select name="site" class="form-control site">
                                            <?php foreach ($site_list as $site) : ?>
                                                <option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>

            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id='addRequisition' class="btn btn-primary disabled">Save</button>
            </div>

        </div>
    </div>
</div>


<!-------------------- Edit Requisition model ----------------------------->
<div class="modal fade" id="editRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form class="frmEditRequisition" action="<?php echo base_url(); ?>dfr/edit_requisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Requisition</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="r_id" name="r_id" value="">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Location</label>
                                <select class="form-control" id="location" name="location" required>
                                    <option value="">--Select--</option>
                                    <?php foreach ($location_data as $row) : ?>
                                        <option value="<?php echo $row['abbr']; ?>"><?php echo $row['office_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" id="department_id" name="department_id" required>
                                    <option value="">--Select--</option>
                                    <?php foreach ($department_data as $department) : ?>
                                        <option value="<?php echo $department['id']; ?>"><?php echo $department['shname']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Requisition Type</label>
                                <select class="form-control" id="req_type" name="req_type" required>
                                    <option value="">--Select--</option>
                                    <option value="Growth">Growth</option>
                                    <option value="Attrition">Attrition</option>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <?php if (get_dept_folder() == "wfm") { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Due Date</label>
                                    <input type="text" class="form-control" id="due_date1" name="due_date" required autocomplete="off">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Due Date</label>
                                    <input type="text" class="form-control" name="due_date" value="<?php echo $DueDate; ?>" readonly>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-4" id='proposed_date_edit_col'>
                            <div class="form-group">
                                <label>Proposed New Date</label>
                                <input type="date" id="proposed_date_edit" name="proposed_date_edit" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Brand</label>
                                <select id="company_brand" name="company_brand" class="brand form-control" required>
                                    <option value="">-- Select Brand --</option>
                                    <?php foreach ($company_list as $key => $value) { ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Position</label>
                                <select class="form-control" id="role_id" name="role_id" required>
                                    <option value="">--Select--</option>
                                    <?php foreach ($role_data as $role) : ?>
                                        <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="form-control" id="fedclient_id" name="client_id" required>
                                    <option value="">--Select--</option>
                                    <?php foreach ($client_list as $client) : ?>
                                        <option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Process</label>
                                <select class="form-control" id="fedprocess_id" name="process_id" required>
                                    <option value="">--Select--</option>
                                    <?php foreach ($process_list as $process) : ?>
                                        <option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Is Asset Required?</label>
                                <select class="form-control" id="is_asset" name="is_asset" required>
                                    <option value="">--Select--</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 asset_required" style="display:none;">
                            <div class="form-group btn-mul">
                                <label>Asset Requirements</label><br>
                                <select id="asset_requisition" name="asset_requisition[]" autocomplete="off1" placeholder="Select Assets" multiple>
                                    <?php
                                    if (!empty($asset_list)) {
                                        foreach ($asset_list as $list) {
                                            $ast = explode(",", @$asset[0]['assets_id']);
                                            $select = '';
                                            $select = in_array($list['id'], $ast) ? "selected" : '';
                                            ?>
                                            <option value="<?= $list['id'] ?>" <?= $select ?>><?= $list['name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Work Type</label>
                                <select class="form-control" id="work_type" name="work_type" required>
                                    <option value="">--Select--</option>
                                    <option value="1">WFO</option>
                                    <option value="2">WFH</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Employee Status</label>
                                <select class="form-control" id="employee_status" name="employee_status">
                                    <option value="">--Select--</option>
                                    <option value="1">Part Time</option>
                                    <option value="2">Full Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Required Qualification</label>
                                <input type="text" class="form-control" id="req_qualification" name="req_qualification" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Required Experience Range</label>
                                <input type="text" class="form-control" id="req_exp_range" name="req_exp_range" value="" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Required no of Position</label>
                                <input type="number" class="form-control" id="req_no_position" name="req_no_position" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Required Skill</label>
                                <input type="text" class="form-control" id="req_skill" name="req_skill" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Batch No</label>
                                <input type="text" class="form-control" id="job_title" name="job_title" value="" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Job Desciption</label>
                                <textarea class="form-control" id="job_desc" name="job_desc"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Additional Information</label>
                                <textarea class="form-control" id="additional_info" name="additional_info"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="site_cspl" style="display: none">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Site</label>
                                    <select name="site" class="form-control site">
                                        <?php foreach ($site_list as $site) : ?>
                                            <option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='editRequisition' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-------------------- Cancel Requisition model ----------------------------->
<div class="modal fade modal-design" id="cancelRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmCancelRequisition" action="<?php echo base_url(); ?>dfr/cancelRequisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cancel Requisition</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="requisition_id" name="requisition_id" value="">
                    <input type="hidden" id="requisition_status" name="requisition_status" value="">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Cancel Reason</label>
                                <textarea class="form-control" id="cancel_comment" name="cancel_comment" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='cancelRequisition' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-------------------- Assign TL Requisition model ----------------------------->
<div class="modal fade modal-design" id="handoverRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmhandoverRequisition" action="<?php echo base_url(); ?>dfr/assignTLRequisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Assign Trainer</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="dept_id" name="dept_id">
                    <input type="hidden" id="role_folder" name="role_folder">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Assign Trainer</label>
                                <select class="form-control" id="assign_trainer" name="assign_trainer" required>
                                    <option>Select</option>
                                    <?php foreach ($trainer_details as $row) : ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . " - " . $row['fusion_id'] . " - " . $row['dept_name'] . " - " . $row['role_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='closedRequisition' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>


<div class="modal fade modal-design" id="assignTlRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmAssignTlRequisition" action="<?php echo base_url(); ?>dfr/assignTLRequisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Assign L1-Supervisor</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id">
                    <input type="hidden" id="dept_id" name="dept_id">
                    <input type="hidden" id="role_folder" name="role_folder">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>L1 Supervisor</label>
                                <select class="form-control" id="l1_supervisor" name="l1_supervisor" required>
                                    <option></option>

                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='assignTlRequisition' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-------------------- Re-Open Requisition model ----------------------------->
<div class="modal fade modal-design" id="reopenRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmReopenRequisition" action="<?php echo base_url(); ?>dfr/reopenRequisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Reopen Requisition</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="r_id" name="r_id">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Reopen Reason</label>
                                <textarea class="form-control" id="reopen_comment" name="reopen_comment" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='reopenRequisition' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-------------------- force closed Requisition Model ----------------------------->
<div class="modal fade modal-design" id="forceclosedRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmforceclosedRequisition" action="<?php echo base_url(); ?>dfr/handover_forced_closed_requisition" data-toggle="validator" method='POST'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Force Close Requisition</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="rid" name="rid">
                    <input type="hidden" id="dept_id" name="dept_id">
                    <input type="hidden" id="role_folder" name="role_folder">
                    <input type="hidden" id="raised_by" name="raised_by">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phase Type</label>
                                <select id="" name="phase_type" class="form-control">
                                    <option value="0">NA</option>
                                    <option value="2">Training</option>
                                    <option value="4">Production</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='closedRequisition' class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
    document.querySelector("#req_no_position").addEventListener("keypress", function (evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });

    $(function () {
        $('#multiselect').multiselect();
        $('#fdoffice_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('#asset_requisition').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('.frmEditRequisition #asset_requisition').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('#fdoffice_ids').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('#select-brand').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('#fclient_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('#select-department').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
        $('.select-box').selectize({
            sortField: 'text'
        });
    });

    $("#is_asset").change(function () {
        let asset = $("#is_asset").val();
        if (asset == '1') {
            $(".asset_required").css("display", "block");
            $("#asset_requisition").attr("required", true);
        } else {
            $("#asset_requisition").multiselect('clearSelection');
            $("#asset_requisition").multiselect('refresh');
            $("#asset_requisition").attr("required", false);
            $(".asset_required").css("display", "none");
            $(".assets_count").css('display', 'none');
            $(".assets_count").html('');
        }
    });

    $(".frmEditRequisition #is_asset").change(function () {
        let asset = $(".frmEditRequisition #is_asset").val();
        if (asset == '1') {
            $(".frmEditRequisition .asset_required").css("display", "block");
            $(".frmEditRequisition #asset_requisition").attr("required", true);
        } else {
            $(".frmEditRequisition #asset_requisition").multiselect('selectAll', true);
            $(".frmEditRequisition #asset_requisition").multiselect('clearSelection');
            $(".frmEditRequisition #asset_requisition").multiselect('refresh');
            $(".frmEditRequisition #asset_requisition").attr("required", false);
            $(".frmEditRequisition .asset_required").css("display", "none");
        }
    });

    $("#asset_requisition").change(function () {
        var assets = $("#asset_requisition").val();
        if (assets != '') {
            let string = "";
            $.each(assets, function (i) {
                var option = $(".frmAddRequisition #asset_requisition option[value='" + assets[i] + "']").text();
                string += '<div class="col-md-4">\
                                <div class="form-group">\
                                    <label>' + option + ' Count</label>\
                                   <input type="number" id="ast_id_' + assets[i] + '" name="ast_id_' + assets[i] + '" class="form-control asset_id" value="" placeholder="Enter Req. ' + option + ' count..." min="1" required>\
                                </div>\
                            </div>';
            });
            $(".assets_count").css('display', 'block');
            $(".assets_count").html(string);
        } else {
            $(".assets_count").css('display', 'none');
        }
    });

    function assignTlRequisition(element) {
        let baseURL="<?=base_url()?>";
        var r_id = element.getAttribute("r_id");
        var dept_id = element.getAttribute("dept_id");
        var role_folder = element.getAttribute("role_folder");
        $('.frmAssignTlRequisition #r_id').val(r_id);
        $('.frmAssignTlRequisition #dept_id').val(dept_id);
        $('.frmAssignTlRequisition #role_folder').val(role_folder);
        $.ajax({
            type: 'POST',
            url: baseURL + 'dfr/getl1super',
            data: 'role_folder=' + role_folder,
            success: function (aList) {
                var json_obj = $.parseJSON(aList);
                $('#l1_supervisor').empty();
                $('#l1_supervisor').append($('#l1_supervisor').val(''));
                $('#l1_supervisor').append($('<option></option>').val('').html('--Select--'));
                for (var i in json_obj) {
                    $('#l1_supervisor').append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name + '-' + json_obj[i].fusion_id + '-' + json_obj[i].dept_name + '-' + json_obj[i].role_name));
                }
            }
        });
        $("#assignTlRequisitionModel").modal('show');
    }
    
    function editRequisition(element){
        let baseURL="<?=base_url()?>";
        var params = element.getAttribute("params");
        var r_id = element.getAttribute("r_id");
        var requisition_id = element.getAttribute("requisition_id");
        var arrPrams = params.split("#");
        if (arrPrams[0] == 'CHA') {

            $('#proposed_date_edit_col').css('display', '');
            $(".frmEditRequisition .site_cspl").css("display", "block");
            $(".frmEditRequisition .site").prop('required', true);
        } else {
            $('#proposed_date_edit_col').css('display', 'none');
            $(".frmEditRequisition .site_cspl").css("display", "none");
            $(".frmEditRequisition .site").removeAttr("required");
        }

        $('#r_id').val(r_id);
        $('#requisition_id').val(requisition_id);
        if (arrPrams[21] == 'editme') {
            $('.frmEditRequisition #location').data('selectize').setValue(arrPrams[0]);
            $('.frmEditRequisition #department_id').data('selectize').setValue(arrPrams[2]);
            $('.frmEditRequisition #req_type').data('selectize').setValue(arrPrams[14]);
            $('.frmEditRequisition #company_brand').data('selectize').setValue(arrPrams[16]);
            $('.frmEditRequisition #role_id').data('selectize').setValue(arrPrams[3]);
            $('.frmEditRequisition #fedclient_id').data('selectize').setValue(arrPrams[4]);
            $('.frmEditRequisition #fedprocess_id').data('selectize').setValue(arrPrams[5]);
            $('.frmEditRequisition #employee_status').data('selectize').setValue(arrPrams[6]);
            $('.frmEditRequisition .site').data('selectize').setValue(arrPrams[20]);
        }
        if (arrPrams[23] == '1') {
            $(".frmEditRequisition .asset_required").css("display", "block");
            let arr = arrPrams[24];
            let sel = new Array();
            sel = arr.split(',');
            $(".frmEditRequisition #asset_requisition").multiselect('select', sel);
            $(".frmEditRequisition #asset_requisition").attr("required", true);
            $(".frmEditRequisition #asset_requisition").multiselect('refresh');
            $('#sktPleaseWait').modal('show');
            $.post(baseURL + "dfr/getRequisitionAssetsData", {
                sel: sel,
                r_id: r_id
            }).done(function(respon) {
                $('#sktPleaseWait').modal('hide');
                if (respon != '0') {
                    var dat_asset = JSON.parse(respon);
                    let string = "";
                    $.each(dat_asset, function(r) {
                        string += '<div class="col-md-4">\
                            <div class="form-group">\
                                <label>' + dat_asset[r].name + ' Count</label>\
                                <input type="number" id="ast_id_' + dat_asset[r].assets_id + '" name="ast_id_' + dat_asset[r].assets_id + '" class="form-control asset_id" value="' + dat_asset[r].assets_required + '" step="1" min="1" placeholder="Enter Req. ' + dat_asset[r].name + ' count..." required>\
                            </div>\
                        </div>';
                    });
                    $(".assets_count").css('display', 'block');
                    $(".assets_count").html(string);
                }

            });
        } else {
            $(".frmEditRequisition #asset_requisition").multiselect('clearSelection');
            $(".frmEditRequisition #asset_requisition").multiselect('refresh');
            $(".frmEditRequisition #asset_requisition").attr("required", false);
        }


        $('.frmEditRequisition #r_id').val(r_id);
        $('.frmEditRequisition #location').val(arrPrams[0]);
        $('.frmEditRequisition #due_date1').val(arrPrams[1]);
        $('.frmEditRequisition #due_date_edit').val(arrPrams[1]);
        $('.frmEditRequisition #department_id').val(arrPrams[2]);
        $('.frmEditRequisition #role_id').val(arrPrams[3]);
        $('.frmEditRequisition #fedclient_id').val(arrPrams[4]);
        $('.frmEditRequisition #fedprocess_id').val(arrPrams[5]);
        $('.frmEditRequisition #employee_status').val(arrPrams[6]);
        $('.frmEditRequisition #req_qualification').val(arrPrams[7]);
        $('.frmEditRequisition #req_exp_range').val(arrPrams[8]);
        $('.frmEditRequisition #is_asset').val(arrPrams[23]);
        $('.frmEditRequisition #work_type').val(arrPrams[22]);
        $('.frmEditRequisition #req_no_position').val(arrPrams[9]);
        $('.frmEditRequisition #job_title').val(arrPrams[10]);
        $('.frmEditRequisition #job_desc').val(arrPrams[11]);
        $('.frmEditRequisition #req_skill').val(arrPrams[12]);
        $('.frmEditRequisition #additional_info').val(arrPrams[13]);
        $('.frmEditRequisition #req_type').val(arrPrams[14]);
        $('.frmEditRequisition #proposed_date_edit').val(arrPrams[15]);
        $('.frmEditRequisition #company_brand').val(arrPrams[16]);
        $('.frmEditRequisition .site').val(arrPrams[20]);
        // alert(arrPrams[20]);

        //$('.frmEditRequisition #filled_no_position').val(arrPrams[14]);

        $("#editRequisitionModel").modal('show');
    }

    function cancelRequisition(element){
        var r_id = $(element).attr("r_id");
        var requisition_id = $(element).attr("requisition_id");
        var requisition_status = $(element).attr("requisition_status");
        $('.frmCancelRequisition #r_id').val(r_id);
        $('.frmCancelRequisition #requisition_id').val(requisition_id);
        $('.frmCancelRequisition #requisition_status').val(requisition_status);
        $("#cancelRequisitionModel").modal('show');
    }
    function handoverRequisition(element){
        var r_id = element.getAttribute("r_id");
        var dept_id = element.getAttribute("dept_id");
        var role_folder = element.getAttribute("role_folder");
        $('.frmhandoverRequisition #r_id').val(r_id);
        $('.frmhandoverRequisition #dept_id').val(dept_id);
        $('.frmhandoverRequisition #role_folder').val(role_folder);
        $("#handoverRequisitionModel").modal('show');
    }
</script>