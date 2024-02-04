<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css" />
<style>
    .welcome_bg {
        background: #d8d8ef;
        padding: 10px 20px;
        margin: 0;
        border-radius: 5px;
    }
    .welcome_widget {
        width: 100%;
    }
    .welcome_img {
        height: 90px;
    }
    .welcome_title {
        font-size: 20px;
        padding: 0 0 5px 0;
        margin: 0;
        font-weight: normal;
    }
    .welcome_title span {
        color: #2205bf;
        font-weight: bold;
    }
    .welcome_widget p {
        color: rgba(0, 0, 0, 0.6);
        padding: 0;
        margin: 0;
        font-size: 14px;
    }
    .common_top {
        width: 100%;
        margin: 10px 0 0 0;
    }
    .heading_title1 {
        font-size: 16px;
        padding: 0 0 5px 0;
        margin: 0;
        color: #000;
        font-weight: bold;
    }
    .heading_big {
        font-size: 20px;
        padding: 0;
        margin: 0;
        color: #2205bf;
        font-weight: bold;
    }
    .user_bg {
        height: 50px;
        width: 50px;
        padding: 10px;
        background: var(--bs-common-btn);
        border-radius: 50%;
        margin: 0 auto 5px auto;
        display: block;
    }
    .user_img {
        height: 25px;
        width: 25px;
        margin: 0 0 5px 0;
        object-fit: contain;
    }
    p {
        padding: 0;
        margin: 0;
    }
    .dt-buttons {
        width: auto;
    }
    .align-items-center {
        display: flex;
        align-items: center;
    }
    .tracking_widget {
        width: 100%;
    }
    .card {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.10rem
    }
    .card-header:first-child {
        border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
    }
    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1)
    }
    .track {
        position: relative;
        background-color: #ddd;
        height: 7px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 60px;
        margin-top: 50px
    }
    .track .step {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }
    .track .step.active:before {
        background: #1fc929;
    }
    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }
    .track .step.active .icon {
        background: #1fc929;
        color: #fff
    }
    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd;
        margin: 0 0 10px 0;
    }
    .track .step.active .text {
        font-weight: 400;
        color: #000
    }
    .track .text {
        display: block;
    }
    .itemside {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        width: 100%
    }
    .itemside .aside {
        position: relative;
        -ms-flex-negative: 0;
        flex-shrink: 0
    }
    .img-sm {
        width: 80px;
        height: 80px;
        padding: 7px
    }
    ul.row,
    ul.row-sm {
        list-style: none;
        padding: 0
    }
    .itemside .info {
        padding-left: 15px;
        padding-right: 7px
    }
    .itemside .title {
        display: block;
        margin-bottom: 5px;
        color: #212529
    }
    p {
        margin-top: 0;
        margin-bottom: 1rem
    }
    .btn-warning {
        color: #ffffff;
        background-color: #ee5435;
        border-color: #ee5435;
        border-radius: 1px
    }
    .btn-warning:hover {
        color: #ffffff;
        background-color: #ff2b00;
        border-color: #ff2b00;
        border-radius: 1px
    }
    .date_title {
        color: rgba(0, 0, 0, 0.5);
        font-size: 13px;
        margin: 5px 0 0 0;
    }
    .header {
        font-size: 16px;
        padding: 0 0 0px 5px;
        margin: 0 0 7px 0;
        color: #000;
        font-weight: bold;
        border-left: 4px solid #ff5a5a;
    }
    .table-parent {
        margin-bottom: 10px;
    }
    .modal textarea {
        width: 100% !important;
        max-width: 100% !important;
    }
    .filter-widget .multiselect-container {
        width: 100%;
    }
    .form_mar_cus {
        margin-top: 9px;
    }
</style>
<div class="wrap">
    <div class="welcome_bg">
        <div class="row align-items-center">
            <div class="col-sm-2">
                <div class="welcome_widget text-center">
                    <img src="<?php echo base_url(); ?>/assets/dfr_it_assets/images/welcome_bg.svg" class="welcome_img" alt="">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="welcome_widget">
                    <h2 class="welcome_title">
                        Welcome to <span><?= $welcome_to ?></span>
                    </h2>
                    <p style="font-weight: bold;">
                        IT Support Dashboard | Ticketing System
                    </p>
                </div>
            </div>
            <?php
            $url = $this->input->server('QUERY_STRING');
            $downloadLink = base_url() . "It_assets_support/excel_export?" . $url; ?>
            <div class="col-sm-4">
                <div class="right_side">
                    <a href="#" class="btn btn_padding filter_btn" data-toggle="modal" data-target="#myModal">View Ticket Status</a>
                    <a href="<?php echo $downloadLink; ?>" class="btn btn_padding filter_btn">Export</a>
                </div>
            </div>
        </div>
    </div>
    <div class="common_top">
        <h2 class="avail_title_heading">#Ticket Pending Dashboard (Total - <?= array_sum($assets_request) ?>)</h2>
        <hr class="sepration_border">
        <div class="row flex_wrap">
            <?php foreach ($assets_request as $key => $value) { ?>
                <div class="col-sm-3 form-group">
                    <div class="white_widget padding_3 column_height">
                        <div class="body_widget text-center">
                            <div class="user_bg">
                                <img src="<?php echo base_url();?>assets_home_v3/images/assets_list.svg" class="user_img" alt="" />
                            </div>
                            <h2 class="avail_title_heading">
                                <?= $key ?>
                            </h2>
                            <p>
                                <?= $value ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="common_top">
        <div class="row flex_wrap">
            <div class="col-sm-8">
                <div class="white_widget padding_3 column_height">
                    <div class="body_widget">
                        <canvas id="my_chart" class=""></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="white_widget padding_3 column_height">
                    <div class="body_widget">
                        <canvas id="myChart1" class="canvas_height1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="common_top">
        <div class="white_widget padding_3">
            <h2 class="avail_title_heading">Search</h2>
            <hr class="sepration_border">
            <div class="body_widget">
                <form method="get">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="filter-widget">
                                <label>Start Date <span id="start_date_req" class="red_bg"></span></label>
                                <input type="date" id="start_date_it_support" name="start_date" class="form-control" value="<?= $start_date ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="filter-widget">
                                <label>End Date <span id="end_date_req" class="red_bg"></span></label>
                                <input type="date" id="end_date_it_support" name="end_date" class="form-control" value="<?= $end_date ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="filter-widget">
                                <label>Location </label>
                                <select id="location_widget" name="location[]" autocomplete="off" placeholder="Select Location" multiple>
                                    <?php foreach ($location_list as $value) {
                                        $sCss = "";
                                        if (in_array($value['abbr'], $location_search)) $sCss = "selected"; ?>
                                        <option value="<?= $value['abbr'] ?>" <?= $sCss ?>><?= $value['office_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="filter-widget">
                                <label>Department </label>
                                <select name="deptid" class="form-control" autocomplete="off" style="cursor: pointer;">
                                    <option value="">All</option>
                                    <?php foreach ($department_data as $value) {
                                        $sel = '';
                                        if ($deptid == $value['id']) $sel = 'selected'; ?>
                                        <option value="<?= $value['id'] ?>" <?= $sel ?>><?= $value['description'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 form_mar_cus">
                            <div class="filter-widget">
                                <label>Aeests Name </label>
                                <select name="ast_name" id="assets_name_search_cat" class="form-control" autocomplete="off" style="cursor: pointer;">
                                    <option value="">All</option>
                                    <?php foreach ($assets_list as $value) {
                                        $sel = '';
                                        if ($ast_name == $value['id']) $sel = 'selected'; ?>
                                        <option value="<?= $value['id'] ?>" <?= $sel ?>><?= $value['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 form_mar_cus">
                            <div class="filter-widget">
                                <label>Issue Category </label>
                                <select name="issue_cat" id="issue_cat_search_result" class="form-control" autocomplete="off" style="cursor: pointer;">
                                    <option value="">All</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 form_mar_cus">
                            <div class="filter-widget">
                                <label>Request Type </label>
                                <select name="req_type" class="form-control" autocomplete="off" style="cursor: pointer;">
                                    <option value="">All</option>
                                    <option value="1" <?php if ($req_type == 1) echo "selected"; ?>>New</option>
                                    <option value="2" <?php if ($req_type == 2) echo "selected"; ?>>Existing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 form_mar_cus">
                            <div class="filter-widget">
                                <label>Status </label>
                                <select name="status" id="stat_tic_search" class="form-control" autocomplete="off" style="cursor: pointer;">
                                    <option value="all">All</option>
                                    <option value="1" <?php if ($status == 1) echo "selected"; ?>>Pending</option>
                                    <option value="2" <?php if ($status == 2) echo "selected"; ?>>Rejected</option>
                                    <option value="3" <?php if ($status == 3) echo "selected"; ?>>On Hold/In-progress</option>
                                    <option value="4" <?php if ($status == 4) echo "selected"; ?>>HOD Pending</option>
                                    <option value="5" <?php if ($status == 5) echo "selected"; ?>>HOD Approved</option>
                                    <option value="6" <?php if ($status == 6) echo "selected"; ?>>HOD Rejected</option>
                                    <option value="7" <?php if ($status == 7) echo "selected"; ?>>Closed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 form_mar_cus">
                            <div class="filter-widget">
                                <label>Search By Ticket ID </label>
                                <input placeholder="For Multiple search using comma seperator" type="text" name="tic_id" maxlength="1000" class="form-control" value="<?= $tic_id ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3 form_mar_cus">
                            <div class="filter-widget">
                                <label>Search By MWP ID </label>
                                <input placeholder="For Multiple search using comma seperator" type="text" maxlength="1000" name="mwp_id" class="form-control" value="<?= $mwp_id ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3 form_mar_cus">
                            <label class="visiblity_hidden d_block">Search</label>
                            <button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="common_top">
        <div class="white_widget padding_3">
            <div class="body_widget">
                <div class="common_table_widget report_hirarchy it_assets_expt new-table">
                    <table id="datatablesSimple" class="table table-bordered table-striped it_assets_expt">
                        <thead>
                            <tr>
                                <th class="table_width_sr">SL. No.</th>
                                <th class="table_width1">Ticket ID</th>
                                <th class="table_width1">Name(MWP ID)</th>
                                <th class="table_width1">Department</th>
                                <th class="table_width1">Role</th>
                                <th class="table_width1">Location</th>
                                <th class="table_width1">Raised Date (Days)</th>
                                <th class="table_width1">Request For</th>
                                <th class="table_width1">Issue type</th>
                                <th class="table_width1">Request Type</th>
                                <th class="table_width1">Current Status</th>
                                <th class="table_width1 leave_columns_fixed">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1;
                            foreach ($ticket_list as $value) {
                                $status = $value['status']; ?>
                                <tr>
                                    <td><strong><?= $c ?></strong></td>
                                    <td><?= $value['ticket_id'] ?></td>
                                    <td><?= $value['user_name'] ?></td>
                                    <td><?= $value['department_name'] ?></td>
                                    <td><?= $value['role_name'] ?></td>
                                    <td><?= $value['user_location'] ?></td>
                                    <td><?= $value['raised_date'] ?> (<?= dateDiffCount($value['raised_date'], date('Y-m-d')) ?>)</td>
                                    <td><?= $value['assets_name'] ?></td>
                                    <td><?= $value['category_name'] ?></td>
                                    <td style="font-weight: bold;"><?php if ($value['req_type'] == 1) echo 'New';
                                                                    else echo 'Existing'; ?>
                                    </td>
                                    <td><?php $hod_close_stat = "";
                                        if ($value['req_type'] == 1 && $value['hod_approval'] == 1 && $status == 7) $hod_close_stat = "(New Asset Assigned)";
                                        elseif ($value['req_type'] == 2 && $value['hod_approval'] == 1 && $status == 7 && $value['it_action'] == 4) $hod_close_stat = "(Customization)";
                                        if ($status == 1) echo 'Pending';
                                        elseif ($status == 2) echo 'Rejected';
                                        elseif ($status == 4) echo 'On Hold/In-progress';
                                        elseif ($status == 5 && $value['hod_approval'] == NULL) echo 'HOD Approve Pending';
                                        elseif ($status == 5 && $value['hod_approval'] == 1) echo 'HOD Approved';
                                        elseif ($status == 6 && $value['hod_approval'] == 2) echo 'HOD Approve Rejected (Closed)';
                                        elseif ($status == 7) echo 'Close' . $hod_close_stat . '';
                                        ?></td>
                                    <td class="leave_columns_fixed action_column_right">
                                        <?php if (($status == 1 || $status == 4)  && $value['req_type'] == 1) : ?>
                                            <a type="button" class="btn btn-new no_padding it_dashboard_tic_new_request" id="<?= $value['id'] ?>" ast_name="<?= $value['assets_name'] ?>" user_name="<?= $value['user_name'] ?>" user_id="<?= $value['user_id'] ?>" assets_id="<?= $value['assets_id'] ?>" curr_stat="<?= $status ?>" ticket_id="<?= $value['ticket_id'] ?>" title="Update & Verify"><img src="<?php echo base_url(); ?>assets_home_v3/images/check.svg" alt=""></a>
                                        <?php endif;
                                        if (($status == 1 || $status == 4) && $value['req_type'] == 2) : ?>
                                            <a type="button" class="btn btn-new no_padding btn_left it_dashboard_tic_existing_assets" id="<?= $value['id'] ?>" ast_name="<?= $value['assets_name'] ?>" user_name="<?= $value['user_name'] ?>" user_id="<?= $value['user_id'] ?>" assets_id="<?= $value['assets_id'] ?>" curr_stat="<?= $status ?>" ticket_id="<?= $value['ticket_id'] ?>" title="Update & Verify"><img src="<?php echo base_url(); ?>assets_home_v3/images/check.svg" alt=""></a>
                                        <?php endif;
                                        if ($status == 1) : ?>
                                            <a type="button" class="btn btn-new no_padding btn_left it_dashboard_tic_reject" id="<?= $value['id'] ?>" ast_name="<?= $value['assets_name'] ?>" user_name="<?= $value['user_name'] ?>" ticket_id="<?= $value['ticket_id'] ?>" title="Reject"><img src="<?php echo base_url(); ?>assets_home_v3/images/delete_action.svg" alt=""></a>
                                        <?php endif;
                                        if ($value['req_type'] == 1 && $value['hod_approval'] == 1 && $status == 5) : ?>
                                            <a type="button" class="btn btn-new no_padding btn_left tic_new_assets_assign" id="<?= $value['id'] ?>" ast_name="<?= $value['assets_name'] ?>" user_name="<?= $value['user_name'] ?>" user_id="<?= $value['user_id'] ?>" assets_id="<?= $value['assets_id'] ?>" curr_stat="<?= $status ?>" ticket_id="<?= $value['ticket_id'] ?>" title="Assign new asset"><img src="<?php echo base_url(); ?>assets_home_v3/images/assets_jitbit.svg" alt=""></a>
                                        <?php endif;
                                        if ($value['req_type'] == 2 && $value['hod_approval'] == 1 && $status == 5 && $value['it_action'] == 4) : ?>
                                            <a type="button" class="btn btn-new no_padding btn_left tic_existing_assets_customization" id="<?= $value['id'] ?>" ast_name="<?= $value['assets_name'] ?>" user_name="<?= $value['user_name'] ?>" user_id="<?= $value['user_id'] ?>" assets_id="<?= $value['assets_id'] ?>" curr_stat="<?= $status ?>" ticket_id="<?= $value['ticket_id'] ?>" title="Asset Update"><img src="<?php echo base_url(); ?>assets_home_v3/images/approved.svg" alt=""></a>
                                        <?php endif; ?>
                                        <a type="button" class="btn btn-new no_padding btn_left tracking_new view_ticket_his" title="View Tracker" id="<?= $value['id'] ?>"><img src="<?php echo base_url(); ?>assets_home_v3/images/view.svg" alt=""></a>
                                    </td>
                                </tr>
                            <?php $c++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- track -->
<div id="modal_track" class="modal fade" role="dialog">
    <div class="modal-dialog modal_common">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">View Ticket History</h4>
            </div>
            <form id="reject_ticket">
                <div class="modal-body">
                    <div class="scroll_pop_new">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="track" id="tracker_view_his">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Model Ticket Reject  -->
<div id="modal_reject" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Name: <span id="user_name"></span> | Reject Ticket [<span id="action_ast_name"></span>] | #Ticket ID: <span id="tic_show_id"></span></h4>
            </div>
            <form id="reject_ticket">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="ticket_id" name="ticket_id" value="" required>
                            <div class="form-group">
                                <label>Reject Reason <span class="red_bg">*</span></label>
                                <textarea id="reject_reason" maxlength="1000" name="reject_reason" class="form-control" placeholder="Write Here" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Model Ticket Reject END -->
<!-- Model For New Request from user -->
<div id="model_tic_new_req_stat" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Name: <span id="user_name"></span> | Take action for new request [<span id="action_ast_name"></span>] | #Ticket ID: <span id="tic_show_id"></span></h4>
            </div>
            <form id="tic_stat_new_req">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="ticket_id" name="ticket_id" value="" required>
                            <div class="form-group">
                                <label>Select Action type <span class="red_bg">*</span></label>
                                <select id="action_type" class="form-control" name="action_type" required>
                                    <option value="" selected>Select a option</option>
                                    <option value="4">On Hold/In-progress</option>
                                    <option value="7">Close</option>
                                    <option value="5">Assign New assets (Need HOD Approval)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Reason <span class="red_bg">*</span></label>
                                <textarea id="reason" maxlength="1000" name="reason" class="form-control" placeholder="Write Here" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Model For New Request from user END -->
<!-- Model For Existing Assets Request from user -->
<div id="model_tic_existing_assets_req_stat" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Name: <span id="user_name"></span> | Take action for existing assets request [<span id="action_ast_name"></span>] | #Ticket ID: <span id="tic_show_id"></span></h4>
            </div>
            <form id="tic_stat_existing_assets_req">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="hidden" id="ticket_id" name="ticket_id" value="" required>
                            <input type="hidden" id="is_inv" name="is_inv" value="" required>
                            <div class="form-group">
                                <label>Select Action Type <span class="red_bg">*</span></label>
                                <select id="action_id" class="form-control" name="action_id" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6" id="assets_action_type_check"></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Reason <span class="red_bg">*</span></label>
                                <textarea id="reason" maxlength="1000" name="reason" class="form-control" placeholder="Write Here" required></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12" id="new_assets_details_replace_action" style="border: 1px solid #ddd;padding: 6px;"></div>
                        <div class="col-sm-12" id="assets_details_user" style="border: 1px solid #ddd;padding: 6px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Model For Existing Assets from user END -->
<!-- Model For Existing Assets Customization -->
<div id="model_tic_existing_assets_customization" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Name: <span id="user_name"></span> | Take action for Assets Customization [<span id="action_ast_name"></span>] | #Ticket ID: <span id="tic_show_id"></span></h4>
            </div>
            <form id="tic_existing_assets_customization">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" id="stcok_details">
                        </div>
                        <div class="col-sm-4">
                            <input type="hidden" id="ticket_id" name="ticket_id" value="" required>
                            <input type="hidden" id="assets_id" name="assets_id" value="" required>
                            <input type="hidden" id="old_stock_id" name="old_stock_id" value="" required>
                            <div class="form-group">
                                <label>Select RAM Type</label>
                                <select id="stock_ram" class="form-control" name="stock_ram">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Select Storage Device Type</label>
                                <select id="stock_storage_type" class="form-control" name="stock_storage_type">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Select Storage Device</label>
                                <select id="stock_storage" class="form-control" name="stock_storage">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Select OS Type</label>
                                <select id="stock_os" class="form-control" name="stock_os">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Configuration / Assets Details</label>
                                <div id="stock_conf_details"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Reason <span class="red_bg">*</span></label>
                                <textarea id="reason" maxlength="1000" name="reason" class="form-control" placeholder="Write Here" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Model For Existing Assets Customization END -->
<!-- Model For New Assets Assign -->
<div id="model_tic_new_assets_assign" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Name: <span id="user_name"></span> | Take action for New Assets Assign [<span id="action_ast_name"></span>] | #Ticket ID: <span id="tic_show_id"></span></h4>
            </div>
            <form id="tic_new_assets_assign_form">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="ticket_id" name="ticket_id" value="" required>
                        <div id="assign_assets_details_input"></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Reason <span class="red_bg">*</span></label>
                                <textarea id="reason" maxlength="1000" name="reason" class="form-control" placeholder="Write Here" required></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12" id="Stock_details_new_assets"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Model For New Assets Assign END -->
<!-- Model view Ticket Status -->
<div class="modal fade tracking_widget" id="myModal" role="dialog">
    <div class="modal-dialog modal_common">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Ticket Status (Assets wise)</h4>
            </div>
            <div class="modal-body">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-parent">
                            <h2 class="avail_title_heading">Status Dashboard</h2>
                            <div class="common_table_widget table_scroll_new top_1">
                                <table id="datatablesSimple" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="table_width1">Status Type</th>
                                            <?php
                                            foreach ($assets_list as $value) {
                                                $assets_id = $value['id'];
                                                echo "<th class='table_width1'>" . $value['name'] . "</th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $data_status = array('reject', 'on_hold', 'hod_approve', 'hod_approve_pending', 'hod_reject', 'close');
                                        for ($i = 0; $i < count($data_status); $i++) {
                                            $index_name = $data_status[$i];
                                            echo '<tr><td>';
                                            if ($i == 0) echo "Rejected";
                                            elseif ($i == 1) echo "On hold/In-progresss";
                                            elseif ($i == 2) echo "HOD Approved";
                                            elseif ($i == 3) echo "HOD Approve Pending";
                                            elseif ($i == 4) echo "HOD Rejected";
                                            elseif ($i == 5) echo "Closed";
                                            echo "</td>";
                                            foreach ($assets_list as  $value) {
                                                $assets_id = $value['id'];
                                                echo "<td>";
                                                if (isset($assets_overall_count[$index_name][$assets_id])) echo $assets_overall_count[$index_name][$assets_id];
                                                else echo "0";
                                                echo "</td>";
                                            }
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Model view Ticket Status END -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
    <?php
    if (isset($action_count['repair'])) $repair = $action_count['repair'];
    else $repair = 0;
    if (isset($action_count['replace'])) $replace = $action_count['replace'];
    else $replace = 0;
    if (isset($action_count['return'])) $return = $action_count['return'];
    else $return = 0;
    if (isset($action_count['customization_approve'])) $customization_approve = $action_count['customization_approve'];
    else $customization_approve = 0;
    if (isset($action_count['customization_reject'])) $customization_reject = $action_count['customization_reject'];
    else $customization_reject = 0;
    if (isset($action_count['new_assets_approve'])) $new_assets_approve = $action_count['new_assets_approve'];
    else $new_assets_approve = 0;
    if (isset($action_count['new_assets_reject'])) $new_assets_reject = $action_count['new_assets_reject'];
    else $new_assets_reject = 0;
    ?>
    var ctx = document.getElementById('my_chart').getContext('2d');
    var barColors = ["#563d7c", "#6146d6", "#edebfe", "#6c757d", "#563d7c", "#6146d6", "#edebfe"];
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Repair', 'Replace', 'Return', 'Customization Approve', 'Customization Reject', 'New Assets Approve', 'New Assets Reject'],
            datasets: [{
                label: '',
                data: [<?= $repair . ',' . $replace . ',' . $return . ',' . $customization_approve . ',' . $customization_reject . ',' . $new_assets_approve . ',' . $new_assets_reject ?>],
                backgroundColor: barColors,
                borderWidth: 2,
                borderSkipped: false,
                borderRadius: 0,
                barThickness: 20
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    <?php
    if (isset($assets_overall_count['reject'])) $reject = array_sum($assets_overall_count['reject']);
    else $reject = 0;
    if (isset($assets_overall_count['on_hold'])) $onhold = array_sum($assets_overall_count['on_hold']);
    else $onhold = 0;
    if (isset($assets_overall_count['hod_approve'])) $hod_approve = array_sum($assets_overall_count['hod_approve']);
    else $hod_approve = 0;
    if (isset($assets_overall_count['hod_approve_pending'])) $hod_approve_pending = array_sum($assets_overall_count['hod_approve_pending']);
    else $hod_approve_pending = 0;
    if (isset($assets_overall_count['hod_reject'])) $hod_reject = array_sum($assets_overall_count['hod_reject']);
    else $hod_reject = 0;
    if (isset($assets_overall_count['close'])) $close = array_sum($assets_overall_count['close']);
    else $close = 0;
    ?>
    var xValues = ["Rejected", "On Hold", "HOD Approved", "HOD Approve Pending", "HOD Rejected", "Closed"];
    var yValues = [<?= $reject . ',' . $onhold . ',' . $hod_approve . ',' . $hod_approve_pending . ',' . $hod_reject . ',' . $close ?>];
    var barColors = [
        "#dd3f4e",
        "#2fabbf",
        "#34ab4f",
        "#258eff",
        "#828a90",
        "#10c469"
    ];
    new Chart("myChart1", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: ""
            }
        }
    });
</script>
<!--start data table with export button-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table/css/buttons.bootstrap.min.css" />
<script src="<?php echo base_url() ?>assets/css/data-table/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.colVis.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#datatablesSimple').DataTable({
            lengthChange: false,
            buttons: [{
                extend: 'excel',
                split: ['', ''],
            }]
        });
        table.buttons().container()
            .appendTo('#datatablesSimple_wrapper .col-sm-6:eq(0)');
    });
</script>
<!--end data table with export button-->
<script>
    $(function() {
        $('#multiselect').multiselect();
        $('#location_widget').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>
<script>
    $(document).on('change', '#assets_name_search_cat', function() {
        var assets_id = $(this).val();
        var request_url = '<?php echo base_url('it_assets_support/get_assets_category_lits'); ?>';
        datas = {
            'assets_id': assets_id
        }
        process_ajax(function(response) {
            var options = '<option value="">All</option>';
            var res = JSON.parse(response);
            if (res.stat == true) {
                $.each(res.datas, function(index, element) {
                    options += '<option value="' + element.id + '">' + element.name + '</option>';
                });
                $('#issue_cat_search_result').html(options);
            }
        }, request_url, datas, 'text');
    });
</script>
<script>
    $(document).on('change', '#stat_tic_search', function() {
        var status = $(this).val();
        if (status == 'all') {
            $("#start_date_it_support, #end_date_it_support").attr("required", "true");
            $("#start_date_req, #end_date_req").text("*");
        } else {
            $("#start_date_it_support, #end_date_it_support").removeAttr("required");
            $("#start_date_req, #end_date_req").text(" ");
        }
    });
    //Auto Scroll
    $(document).scrollTop($(document).height());
</script>