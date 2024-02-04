<link href="<?= base_url() ?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<script src="<?= base_url() ?>assets/css/search-filter/assets/js/all.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

<style>
    .btn-table {
        float: right;
    }

    .card-header {
        background: #f1e9e933;
        border-bottom: 1px solid #cbcfd8ba;
        color: #1b1515;
        position: relative;
    }

    .header {
        font-size: 1rem;
        font-weight: 600;

    }

    .dataTables_length {
        margin-bottom: 15px;
    }

    .dataTables_length .form-select {
        background: #fff;
        border: none;
        border: 1px solid #ccc;
        border-radius: 5px;
        height: 35px !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        height: 35px !important;
    }

    .btn-new {
        width: 30px;
        padding: 1px;
        font-size: 14px;
        background: #fff;
        position: absolute;
        top: -1px;

    }

    .hide {
        display: none;
    }

    .myDIV:hover+.hide {
        display: block;
        color: red;
    }

    .dataTables_wrapper .buttons-excel {
        text-transform: capitalize;
        background: #337ab7;
        border: none !important;
        color: #fff;
        border-radius: 1px;
        transition: 1s;
        width: 50px;
        border: none;
        padding: 8px;
        font-size: 11px;
    }

    .dataTables_wrapper .buttons-excel:hover {
        background: #286090 !important;
        border: none !important;
        color: #fff;
    }

    .dataTables_wrapper .buttons-excel:focus {
        background: #286090 !important;
        border: none !important;
        color: #fff !important;
    }

    .dataTables_filter input {
        border-radius: 1px !important;
    }

    .dataTables_filter input:focus {
        outline: none !important;

    }

    .dt-buttons {
        margin-bottom: 5px !important;
    }
</style>

<div class="wrap">
    <section class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="white_widget padding_3">
                    <div class="row d_flex">
                        <div class="col-md-6">
                            <h2 class="avail_title_heading d_inline"> Bulk Stock Import </h2>
                            <button type="button" id="info-excel" class="btn btn-xs btn-new slight_minus" data-toggle="modal" data-target="#myModal"><img src="<?php echo base_url(); ?>assets_home_v3/images/global_info.svg" alt=""></button>
                        </div>
                        <div class="col-md-6">
                            <div class="right_side">
                                <a href="<?= base_url() ?>it_assets_import/sample_data/Stock_import_sample_formate.xlsx" download type="button" class="btn btn_padding filter_btn btn-download">Sample Download</a>
                            </div>
                        </div>
                    </div>
                    <hr class="sepration_border">
                    <div class="body_widget">
                        <form method="post" enctype="multipart/form-data" autocomplete="off" id="file_upload_it">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group file-filled">
                                        <input type="hidden" name="import_type" value="stock" required>
                                        <label for="full_form">Upload Excel <span class="red_bg">*</span></label>
                                        <div class="file_upload_style">
                                            <input type="file" name="upload_file" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="full_form">Location <span class="red_bg">*</span></label>
                                        <select class="form-control" id="it_location" name="location_name" required="required">
                                            <option selected disabled value="">Select a location</option>
                                            <?php foreach ($location_list as $key => $value) { ?>
                                                <option value="<?php echo $value['abbr']; ?>"><?php echo $value['office_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="full_form">Stock Import Type <span class="red_bg">*</span></label>
                                        <select class="form-control" id="stock_type" name="stock_type" required="required">
                                            <option value="" selected>Select a option</option>
                                            <option value="1">New</option>
                                            <option value="2">Modification/Update</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button id="uploadButton" type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Upload & Verify</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="white_widget padding_3">
                <div class="row d_flex">
                    <div class="col-md-3">
                        <span class="header">Bulk Stock Assignment </span>
                        <button type="button" id="info-excel" class="btn btn-xs btn-new" data-toggle="modal" data-target="#myModal2"><img src="<?php echo base_url(); ?>assets_home_v3/images/global_info.svg" alt=""></button>
                    </div>
                    <div class="col-md-9">
                        <div class="right_side">
                            <a href="<?= base_url() ?>it_assets_import/sample_data/excel_import_stock_assignment_ticketing.xlsx" type="button" class="btn btn_padding filter_btn btn-download" download>Sample Ticketing</a>
                            <a href="<?= base_url() ?>it_assets_import/sample_data/excel_import_stock_assignment_onboarding.xlsx" type="button" class="btn btn_padding filter_btn btn-download" download>Sample Onboarding</a>
                            <a href="<?= base_url() ?>it_assets_import/sample_data/excel_import_stock_assignment_jitbit.xlsx" type="button" class="btn btn_padding filter_btn btn-download" download>Sample Jitbit</a>
                            <a href="<?= base_url() ?>it_assets_import/sample_data/excel_import_stock_floor_assign_jitbit.xlsx" type="button" class="btn btn_padding filter_btn btn-download" download>Sample Floor Assign</a>
                        </div>
                    </div>
                </div>
                <hr class="sepration_border">
                <div class="body_widget">
                    <div class="row">
                        <form id="file_upload_it" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="col-md-4">
                                <div class="form-group file-filled">
                                    <input type="hidden" name="import_type" value="assignment" required>
                                    <label for="full_form">Upload Excel <span class="red_bg">*</span></label>
                                    <div class="file_upload_style">
                                        <input type="file" name="upload_file" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="full_form">Location <span class="red_bg">*</span></label>
                                    <select class="form-control" id="it_location" name="location_name" required="required">
                                        <option selected disabled value="">Select a location</option>
                                        <?php foreach ($location_list as $key => $value) { ?>
                                            <option value="<?php echo $value['abbr']; ?>"><?php echo $value['office_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="full_form">Assignment Types <span class="red_bg">*</span></label>
                                    <select class="form-control" id="req_type" name="req_type" required="required">
                                        <option value="" selected>Select a option</option>
                                        <option value="1">Onboding Recruitment (DFR)</option>
                                        <option value="2">IT Support (Ticketing System)</option>
                                        <option value="3">IT Support (Jitbit)</option>
                                        <option value="4">Floor Assign (Jitbit)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button id="uploadButton" type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Upload & Verify</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="white_widget padding_3">
            <h2 class="avail_title_heading">Excel Validation Details</h2>
            <hr class="sepration_border">
            <div class="body_widget common_table_widget">
                <?php if ($excel_error_result !== false) {
                    $count = count($excel_error_result);
                ?>
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Excel SL</th>
                                <th>Excel Issues</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $c = 1;
                            foreach ($excel_error_result as $key => $value) { ?>
                                <tr>
                                    <td><?= $c ?></td>
                                    <td><?= $key ?></td>
                                    <td>
                                        <?php
                                        foreach ($excel_error_result[$key] as $value) {
                                            echo $value;
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php $c++;
                            } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</section>
</div>

<!-- Modal Add -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Info</h4>
            </div>
            <div class="modal-body">
                <p>
                    <strong>1. </strong>Only <span style="color:red">.xls</span> & <span style="color:red">.xlsx</span> excel files are supported.<br>
                    <strong>2. </strong>* Mark columns are case sensitive values. Please check and make sure that the values are match with Master Entry data.<br>
                    <strong>3. </strong>Red Highlighted columns are mandatory fileds.<br>
                    <strong>4. </strong>You can identify the exact row error in Excel using "Excel SL" number from "Excel Validation Details".<br>
                    <strong>5. </strong> Master Data are case-sensitive. Please validate excel data with Master Entry.<br>
                    <strong>6. </strong> For stock Update or Modify only below mention Fields can't be Update or modified - <br> <strong>Hardware Name, Brand, Model, Serial Number.</strong>

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_new" data-dismiss="modal"></button>
                <h4 class="modal-title">Info</h4>
            </div>
            <div class="modal-body">
                <p>
                    <strong>1. </strong>Only <span style="color:red">.xls</span> & <span style="color:red">.xlsx</span> excel files are supported.<br>
                    <strong>2. </strong>* Mark columns are case sensitive values. Please check and make sure that the values are match with Master Entry data.<br>
                    <strong>3. </strong>Red Highlighted columns are mandatory fileds.<br>
                    <strong>4. </strong>You can identify the exact row error in Excel using "Excel SL" number from "Excel Validation Details".<br>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                // 'excel'
                {
                    extend: 'excelHtml5',
                    text: 'Export to excel',
                    titleAttr: 'Export to excel',
                }
            ]
        });
    });
</script>
<script>
    // $(document).ready(function () {
    //     $('#example').DataTable();
    // });

    // $(document).ready(function() {
    //     var table = $('#example').DataTable({
    //         lengthChange: false,
    //         buttons: [{
    //             extend: 'excel',
    //             split: ['', ''],
    //         }]
    //     });
    //     table.buttons().container().appendTo('#example_wrapper .col-sm-6:eq(0)');
    // });


    $('INPUT[type="file"]').change(function() {
        //var ext = this.value.match(/\.(.+)$/)[1];
        var fileName = $(this).val();
        var ext = fileName.substring(fileName.lastIndexOf(".") + 1, fileName.length);
        ext = ext.toLowerCase();
        switch (ext) {
            case 'xls':
                $('#uploadButton').attr('disabled', false);
                break;
            case 'xlsx':
                $('#uploadButton').attr('disabled', false);
                break;
            default:
                alert('This is not an allowed file type.');
                $('#uploadButton').attr('disabled', true);
                this.value = '';
        }
    });
</script>
<!-- Data-table -end -->