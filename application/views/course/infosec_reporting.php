<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" />

<style>



    #default-datatable th{
        font-size:12px;
    }
    #default-datatable th{
        font-size:12px;
    }

    .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
        padding:5px;
    }

    .modal-dialog{
        width:750px;
    }

    td.details-control {
        background: url('<?php echo base_url() ?>assets/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('<?php echo base_url() ?>assets/images/details_close.png') no-repeat center center;
        cursor: pointer;
    }
table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting_asc_disabled, table.dataTable thead>tr>th.sorting_desc_disabled, table.dataTable thead>tr>td.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting_asc_disabled, table.dataTable thead>tr>td.sorting_desc_disabled {
 
    padding-right: 10px!important;
}
    .btn-label {
        position: relative;
        left: -12px;
        display: inline-block;
        padding: 6px 12px;
        background: rgba(0,0,0,0.15);
        border-radius: 3px 0 0 3px;
    }
    .btn-labeled {
        padding-top: 0;
        padding-bottom: 0;
    }
    .btn {
        margin-bottom:0px;
    }

    .label {
        position: relative;
        left: -12px;
        display: inline-block;
        padding: 6px 12px;
        border-radius: 3px 0 0 3px;
    }
    /*	.labeled {padding-top: 0;padding-bottom: 0;} */

    .ladda-button{
        position:relative
    }
    .ladda-button .ladda-spinner{
        position:absolute;
        z-index:2;
        display:inline-block;
        width:32px;
        height:32px;
        top:50%;
        margin-top:-16px;
        opacity:0;
        pointer-events:none
    }
    .ladda-button .ladda-label{
        position:relative;
        z-index:3
    }
    .ladda-button .ladda-progress{
        position:absolute;
        width:0;
        height:100%;
        left:0;
        top:0;
        background:rgba(0,0,0,0.2);
        visibility:hidden;
        opacity:0;
        -webkit-transition:0.1s linear all !important;
        -moz-transition:0.1s linear all !important;
        -ms-transition:0.1s linear all !important;
        -o-transition:0.1s linear all !important;
        transition:0.1s linear all !important
    }
    .ladda-button[data-loading] .ladda-progress{
        opacity:1;
        visibility:visible
    }
    .ladda-button,.ladda-button .ladda-spinner,.ladda-button .ladda-label{
        -webkit-transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important;
        -moz-transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important;
        -ms-transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important;
        -o-transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important;
        transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important
    }
    .ladda-button[data-style=zoom-in],.ladda-button[data-style=zoom-in] .ladda-spinner,.ladda-button[data-style=zoom-in] .ladda-label,.ladda-button[data-style=zoom-out],.ladda-button[data-style=zoom-out] .ladda-spinner,.ladda-button[data-style=zoom-out] .ladda-label{
        -webkit-transition:0.3s ease all !important;
        -moz-transition:0.3s ease all !important;
        -ms-transition:0.3s ease all !important;
        -o-transition:0.3s ease all !important;
        transition:0.3s ease all !important
    }
    .ladda-button[data-style=expand-right] .ladda-spinner{
        right:14px
    }
    .ladda-button[data-style=expand-right][data-size="s"] .ladda-spinner,.ladda-button[data-style=expand-right][data-size="xs"] .ladda-spinner{
        right:4px
    }
    .ladda-button[data-style=expand-right][data-loading]{
        padding-right:56px
    }
    .ladda-button[data-style=expand-right][data-loading] .ladda-spinner{
        opacity:1
    }
    .ladda-button[data-style=expand-right][data-loading][data-size="s"],.ladda-button[data-style=expand-right][data-loading][data-size="xs"]{
        padding-right:40px
    }
    .ladda-button[data-style=expand-left] .ladda-spinner{
        left:14px
    }
    .ladda-button[data-style=expand-left][data-size="s"] .ladda-spinner,.ladda-button[data-style=expand-left][data-size="xs"] .ladda-spinner{
        left:4px
    }
    .ladda-button[data-style=expand-left][data-loading]{
        padding-left:56px
    }
    .ladda-button[data-style=expand-left][data-loading] .ladda-spinner{
        opacity:1
    }
    .ladda-button[data-style=expand-left][data-loading][data-size="s"],.ladda-button[data-style=expand-left][data-loading][data-size="xs"]{
        padding-left:40px
    }
    .ladda-button[data-style=expand-up]{
        overflow:hidden
    }
    .ladda-button[data-style=expand-up] .ladda-spinner{
        top:-32px;
        left:50%;
        margin-left:-16px
    }
    .ladda-button[data-style=expand-up][data-loading]{
        padding-top:54px
    }
    .ladda-button[data-style=expand-up][data-loading] .ladda-spinner{
        opacity:1;
        top:14px;
        margin-top:0
    }
    .ladda-button[data-style=expand-up][data-loading][data-size="s"],.ladda-button[data-style=expand-up][data-loading][data-size="xs"]{
        padding-top:32px
    }
    .ladda-button[data-style=expand-up][data-loading][data-size="s"] .ladda-spinner,.ladda-button[data-style=expand-up][data-loading][data-size="xs"] .ladda-spinner{
        top:4px
    }
    .ladda-button[data-style=expand-down]{
        overflow:hidden
    }
    .ladda-button[data-style=expand-down] .ladda-spinner{
        top:62px;
        left:50%;
        margin-left:-16px
    }
    .ladda-button[data-style=expand-down][data-size="s"] .ladda-spinner,.ladda-button[data-style=expand-down][data-size="xs"] .ladda-spinner{
        top:40px
    }
    .ladda-button[data-style=expand-down][data-loading]{
        padding-bottom:54px
    }
    .ladda-button[data-style=expand-down][data-loading] .ladda-spinner{
        opacity:1
    }
    .ladda-button[data-style=expand-down][data-loading][data-size="s"],.ladda-button[data-style=expand-down][data-loading][data-size="xs"]{
        padding-bottom:32px
    }
    .ladda-button[data-style=slide-left]{
        overflow:hidden
    }
    .ladda-button[data-style=slide-left] .ladda-label{
        position:relative
    }
    .ladda-button[data-style=slide-left] .ladda-spinner{
        left:100%;
        margin-left:-16px
    }
    .ladda-button[data-style=slide-left][data-loading] .ladda-label{
        opacity:0;
        left:-100%
    }
    .ladda-button[data-style=slide-left][data-loading] .ladda-spinner{
        opacity:1;
        left:50%
    }
    .ladda-button[data-style=slide-right]{
        overflow:hidden
    }
    .ladda-button[data-style=slide-right] .ladda-label{
        position:relative
    }
    .ladda-button[data-style=slide-right] .ladda-spinner{
        right:100%;
        margin-left:-16px
    }
    .ladda-button[data-style=slide-right][data-loading] .ladda-label{
        opacity:0;
        left:100%
    }
    .ladda-button[data-style=slide-right][data-loading] .ladda-spinner{
        opacity:1;
        left:50%
    }
    .ladda-button[data-style=slide-up]{
        overflow:hidden
    }
    .ladda-button[data-style=slide-up] .ladda-label{
        position:relative
    }
    .ladda-button[data-style=slide-up] .ladda-spinner{
        left:50%;
        margin-left:-16px;
        margin-top:1em
    }
    .ladda-button[data-style=slide-up][data-loading] .ladda-label{
        opacity:0;
        top:-1em
    }
    .ladda-button[data-style=slide-up][data-loading] .ladda-spinner{
        opacity:1;
        margin-top:-16px
    }
    .ladda-button[data-style=slide-down]{
        overflow:hidden
    }
    .ladda-button[data-style=slide-down] .ladda-label{
        position:relative
    }
    .ladda-button[data-style=slide-down] .ladda-spinner{
        left:50%;
        margin-left:-16px;
        margin-top:-2em
    }
    .ladda-button[data-style=slide-down][data-loading] .ladda-label{
        opacity:0;
        top:1em
    }
    .ladda-button[data-style=slide-down][data-loading] .ladda-spinner{
        opacity:1;
        margin-top:-16px
    }
    .ladda-button[data-style=zoom-out]{
        overflow:hidden
    }
    .ladda-button[data-style=zoom-out] .ladda-spinner{
        left:50%;
        margin-left:-16px;
        -webkit-transform:scale(2.5);
        -moz-transform:scale(2.5);
        -ms-transform:scale(2.5);
        -o-transform:scale(2.5);
        transform:scale(2.5)
    }
    .ladda-button[data-style=zoom-out] .ladda-label{
        position:relative;
        display:inline-block
    }
    .ladda-button[data-style=zoom-out][data-loading] .ladda-label{
        opacity:0;
        -webkit-transform:scale(0.5);
        -moz-transform:scale(0.5);
        -ms-transform:scale(0.5);
        -o-transform:scale(0.5);
        transform:scale(0.5)
    }
    .ladda-button[data-style=zoom-out][data-loading] .ladda-spinner{
        opacity:1;
        -webkit-transform:none;
        -moz-transform:none;
        -ms-transform:none;
        -o-transform:none;
        transform:none
    }
    .ladda-button[data-style=zoom-in]{
        overflow:hidden
    }
    .ladda-button[data-style=zoom-in] .ladda-spinner{
        left:50%;
        margin-left:-16px;
        -webkit-transform:scale(0.2);
        -moz-transform:scale(0.2);
        -ms-transform:scale(0.2);
        -o-transform:scale(0.2);
        transform:scale(0.2)
    }
    .ladda-button[data-style=zoom-in] .ladda-label{
        position:relative;
        display:inline-block
    }
    .ladda-button[data-style=zoom-in][data-loading] .ladda-label{
        opacity:0;
        -webkit-transform:scale(2.2);
        -moz-transform:scale(2.2);
        -ms-transform:scale(2.2);
        -o-transform:scale(2.2);
        transform:scale(2.2)
    }
    .ladda-button[data-style=zoom-in][data-loading] .ladda-spinner{
        opacity:1;
        -webkit-transform:none;
        -moz-transform:none;
        -ms-transform:none;
        -o-transform:none;
        transform:none
    }
    .ladda-button[data-style=contract]{
        overflow:hidden;
        width:100px
    }
    .ladda-button[data-style=contract] .ladda-spinner{
        left:50%;
        margin-left:-16px
    }
    .ladda-button[data-style=contract][data-loading]{
        border-radius:50%;
        width:52px
    }
    .ladda-button[data-style=contract][data-loading] .ladda-label{
        opacity:0
    }
    .ladda-button[data-style=contract][data-loading] .ladda-spinner{
        opacity:1
    }
    .ladda-button[data-style=contract-overlay]{
        overflow:hidden;
        width:100px;
        box-shadow:0px 0px 0px 3000px rgba(0,0,0,0)
    }
    .ladda-button[data-style=contract-overlay] .ladda-spinner{
        left:50%;
        margin-left:-16px
    }
    .ladda-button[data-style=contract-overlay][data-loading]{
        border-radius:50%;
        width:52px;
        box-shadow:0px 0px 0px 3000px rgba(0,0,0,0.8)
    }
    .ladda-button[data-style=contract-overlay][data-loading] .ladda-label{
        opacity:0
    }
    .ladda-button[data-style=contract-overlay][data-loading] .ladda-spinner{
        opacity:1
    }


    .faicon{
        color:red;
        cursor:pointer;
    }

    .list-group-item{
        position: relative;
        display: block;
        padding: 10px 15px;
        margin-bottom: -1px;
        background-color: #fff;
        border: 0px;
    }

    .list-inline > li {
        display: inline-block;
        padding-left: 5px;
        padding-right: 50px;
    }

    .course_title{
        font-family:"Roboto";
        font-size:15px;
        font-weight:bold;
        color:black;

    }


    .spinner {
        z-index:10000;
        position: absolute;
        left: 50%;
        top: 50%;
        height:60px;
        width:60px;
        margin:0px auto;
        -webkit-animation: rotation .6s infinite linear;
        -moz-animation: rotation .6s infinite linear;
        -o-animation: rotation .6s infinite linear;
        animation: rotation .6s infinite linear;
        border-left:6px solid rgba(0,174,239,.15);
        border-right:6px solid rgba(0,174,239,.15);
        border-bottom:6px solid rgba(0,174,239,.15);
        border-top:6px solid rgba(0,174,239,.8);
        border-radius:100%;

    }

    @-webkit-keyframes rotation {
        from {
            -webkit-transform: rotate(0deg);
        }
        to {
            -webkit-transform: rotate(359deg);
        }
    }
    @-moz-keyframes rotation {
        from {
            -moz-transform: rotate(0deg);
        }
        to {
            -moz-transform: rotate(359deg);
        }
    }
    @-o-keyframes rotation {
        from {
            -o-transform: rotate(0deg);
        }
        to {
            -o-transform: rotate(359deg);
        }
    }
    @keyframes rotation {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(359deg);
        }
    }
.btn-new {
 width: 100px;
padding: 10px;
margin-top: 24px;
color: #fff;
background-color: #337ab7;
border: none;
border-radius: 3px;
}

.btn-new:hover,.btn-new:focus {
  color: #fff;
  background-color: #286090;
  border-color: #204d74;
}
.filter-widget .multiselect-container{
    width: 100%!important;
}
.filter-widget .open > .dropdown-toggle.btn-default:hover {
  border: 1px solid #188ae2!important;
  box-shadow: none!important;
  background: #fff!important;
}
.btn-Group{
    display: flex;
}
.btn-Group .btn{
    flex: 1;
    margin: 0 .4rem 0 .4rem!important;
}
.ana-report{
    padding: 10px 16px !important;
}
.new-table th, .new-table td{
    font-size: 11px!important;
    padding: 7px!important;
}
.new-table{
    padding: 8px;
    overflow-x: scroll;
}
.new-table .label {
  background-color: #35b8e0;
  width: 40px;
  padding: 4px !important;
  margin: 0px 0px 0 12px;
  border-radius: 5px !important;
}
.dataTables_filter input{
    outline: none!important;
}
.paddIng {
    padding: 10px 6px 10px 6px;
}
.table > thead > tr > th {
  vertical-align: top!important;
  text-align: center !important;
}
.eye-icon{
    text-align: center;
    padding: 10px;
}
</style>

<div class="spinner" style="display:none"></div>

<?php $abc = '' ?>
<div class="wrap">
    <section class="app-content">
        <div class="row">

            <!-- DataTable -->
            <div class="col-md-12">
                <div class="widget">
                    <header class="widget-header" style="background-color:yellow">
                        <div class="row">
                            <div class="col-sm-2 col-12 ">
                                <h4 class="widget-title btn label labeled">Course Reports</h4>
                            </div>
                            <div class="col-sm-1 col-1 pull-right">
                                <a href="<?php echo base_url(); ?>course/view_subject_list/<?php echo $categ_id; ?>" class="btn  btn-success" title="Navigate Back"><i class="glyphicon glyphicon-arrow-left"></i> Back </a>
                            </div>
                        </div>
                    </header><!-- .widget-header -->
                </div><!-- .widget-body -->
            </div><!-- .widget -->

            <form id="form_new_user" method="POST" action="" enctype="multipart/form-data" style="display:<?php echo ($categ_id != '' && $course_id != '') ? 'block' : 'none'; ?>">  
               <div class="col-md-12">
                <div class="widget">
                  <div class="widget-body filter-widget">
                        <div class="row">
                           
                            <div class="col-sm-3  ">
                                <div class="form-group ">
                                    <label>Location</label>
                                        <select required name="office_id[]" id="multiselectwithsearch" multiple="multiple">
                                        <?php foreach ($location_list as $loc) { 
                                                $sCss = "";
                                                if (in_array($loc['abbr'], $office_id)) $sCss = "selected";
                                        ?>
                                                <option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name'] ?></option>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>
                              <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="user_type">                                        
                                        <option value="" <?php if ($user_type == '') { echo 'selected'; } ?>>All Users</option>
                                        <option value="1,4" <?php if ($user_type == '1,4') { echo 'selected'; } ?>>Active Users</option>                                        
                                    </select>
                                </div>
                            </div>
                             <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label>Report Type</label>
                                    <select class="form-control" name="report_type">
                                        <option value="A" <?php if ($report_type == 'A') { echo 'selected'; } ?>>Assigned Users</option>
                                        <option value="E" <?php if ($report_type == 'E') { echo 'selected'; } ?>>Examination</option>
                                        <option value="F" <?php if ($report_type == 'F') { echo 'selected'; } ?>>Freeze</option>
                                    </select>
                                </div>
                            </div>
                              <div class="col-sm-1 ">
                                <button class="btn-new" type="submit" id='search' name='search' value="search">Search</button>
                              </div>                           
                        </div>
                    </div>
                   
                </div>
            </div>
        </form>

            <form method="post">
                <div class="col-md-12" style="display:<?php echo ($categ_id != '' && $course_id != '') ? 'none' : 'block'; ?>">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary text-white form-control" name="assigned" value="A" >Assigned Users <span class="badge badge-light"><?php echo $total_assigned['total_assigned']; ?></span></button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary text-white form-control" name="examination" value="E" >Examination <span class="badge badge-light"></span></button>
                                </div> 
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary text-white form-control" name="freez" value="F" >Freeze <span class="badge badge-light"><?= $total_freez['total_freez']; ?></span></button>
                                </div> 

                            </div>

                        </div><!-- .widget-body -->
                    </div><!-- .widget -->
                </div>

                <div class="col-md-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-8 pull-right">

                                    <input type="hidden" name="hidden_office_id" value="<?php if(!empty($office_id)){ echo implode(',', $office_id);}?>">
                                    <input type="hidden" name="hidden_user_type" value="<?=$user_type?>">
                                    <input type="hidden" name="hidden_report_type" value="<?=$report_type?>">

                                    <div class="btn-Group">
                                    <button type="submit" class="btn btn-primary text-white form-control" name="export" value="<?php echo $cat == 'A' ? 'A' : 'E'; ?>" style="display:<?php echo $cat == '' ? 'none' : 'block'; ?>">Export</button>
                                    <a class="btn btn-primary text-white form-control ana-report" href="<?php echo base_url(); ?>course/report_analytics/<?php echo $categ_id; ?>/<?php echo $course_id; ?>" style="display:<?php echo $cat == '' ? 'none' : 'block'; ?>">Analytics Report</a>
                                    <button type="button" style="display:none;" class="btn form-control text-white success" onclick="unfreez_user_all();" id="unfreez_all">Un-Freeze</button>
                                    <button type="submit" class="btn btn-primary text-white form-control" name="summary" value="S" style="display:<?php echo $cat == '' ? 'none' : 'block'; ?>">Summary Report</button>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="alert alert-warning alert-dismissible" role="alert" style="display:<?php echo $this->input->get('error') == 1 ? 'block' : 'none'; ?>">
                                        <strong>Select course from menu to get report!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div><!-- .widget-body -->
                    </div><!-- .widget -->
                </div>
            </form>		


            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-body-NA paddIng">
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($cat == 'A') { ?>
                                    <div class="table-responsive new-table">
                                    <table class="table datatable" >
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Fusion ID</th>
                                                <th scope="col">User Name</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Assigned By</th>
                                                <th scope="col">Assigned Date</th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Process</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Assigned To FID</th>
                                                <th scope="col">Assigned To</th>
                                                <th scope="col">Course Name</th>
                                                <th scope="col">User Status</th>
                                                <th scope="col">Viewed Course</th>
                                                <th scope="col">Study Completed</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($assigned_users as $agents) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td><?php echo $agents['fusionid']; ?></td>
                                                    <td><?php echo $agents['name']; ?></td>
                                                    <td><?php echo $agents['department_name']; ?></td>
                                                    <td>
                                                        <?php
                                                    if($agents['assign_log']!="") {
                                                      preg_match("/(?<=User:).*?(?=FID)/", $agents['assign_log'], $assign_by);
                                                        echo $assign_by[0];
                                                    }
                                                    else { echo "Auto Assign"; }
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                        // preg_match("/(?<=Date: ).*?(?= RemoteIP)/", $agents['assign_log'], $assign_Date);
                                                        // echo $assign_Date[0];
                                                            echo $agents['assinged_date']
                                                        ?></td>
                                                    <td><?php echo get_client_name_by_user_id($agents['agent_id']); ?></td>
                                                    <td><?php echo get_process_name_by_user_id($agents['agent_id']); ?></td>
                                                    <td><?php echo $agents['office_id']; ?></td>
                                                    <td><?php echo $agents['assigned_to_fusionid']; ?></td>
                                                    <td><?php echo $agents['assigned_to']; ?></td>
                                                    <td><?php echo $agents['course_name']; ?></td> 
                                                    <td>
										<?php
											
											
											$_status=$agents['status'];
											
																						
											if($_status==1) echo '<span class="label label-info">Active</span>'; 
											else if($_status==0) echo '<span class="label label-danger">Terms</span>';
											else if($_status==2) echo '<span class="label label-warning">Pre-Terms</span>';
											else if($_status==3) echo '<span class="label label-warning">Suspended</span>'; 
											else if($_status==4) echo '<span class="label label-primary">New Users</span>';
											else if($_status==5) echo '<span class="label label-warning">Bench Paid</span>';
											else if($_status==6) echo '<span class="label label-warning">Bench Unpaid</span>'; 
											else if($_status==7) echo '<span class="label label-info">Furlough</span>';
											else echo '<span class="label label-default">Deactive</span>';
										?>
										</td>
                                                    <td><div class="eye-icon">
                                                        <i style="color:<?php echo $agents['is_view'] == 1 ? 'green' : 'red' ?>" class="fa <?php echo $agents['is_view'] == 1 ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                                                    </div></td>
                                                    <td>
                                                        <div class="eye-icon"><i style="color:<?php echo $agents['is_complete'] == 1 ? 'green' : 'red' ?>" class="fa <?php echo $agents['is_complete'] == 1 ? 'fa-check' : 'fa-times' ?>"></i>
                                                        </div>
                                                        </td>
                                                </tr>
                                                <?php $i = $i + 1; ?>
                                            <?php } ?> 
                                        </tbody>
                                    </table>
                                <?php } elseif ($cat == 'E') { ?>	 
                                    <table class="table datatable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Fusion ID</th>
                                                <th scope="col">User Name</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Process</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Assigned To FID</th>
                                                <th scope="col">Assigned To</th>
                                                <th scope="col">Exam Name</th>
                                                <th scope="col">Set Name</th>
                                                <th scope="col">Exam Date</th>
                                                <th scope="col">Pass Marks</th>
                                                <th scope="col">Scored</th>
                                                <th scope="col">Result</th>
                                                <th scope="col">User Status</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($assigned_users as $agents) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i ?></th>
                                                    <td><?php echo $agents['fusionid']; ?></td>
                                                    <td><?php echo $agents['username']; ?></td>
                                                    <td><?php echo $agents['department_name']; ?></td>
                                                    <td style="width:100px;"><?php echo get_client_name_by_user_id($agents['user_id']); ?></td>
                                                    <td style="width:100px;"><?php echo get_process_name_by_user_id($agents['user_id']); ?></td>
                                                    <td><?php echo $agents['office_id']; ?></td>
                                                    <td><?php echo $agents['assigned_to_fusionid']; ?></td>
                                                    <td><?php echo $agents['assigned_to']; ?></td>
                                                    <td style="width:100px;"><?php echo $agents['description']; ?></td>
                                                    <td style="width:100px;"><?php echo $agents['set_name']; ?></td>
                                                    <td><?php echo $agents['exam_start_time']; ?></td>

                                                    <td><?php echo $agents['pass_marks']; ?></td>
                                                    <td><?php echo $agents['scored']; ?></td>
                                                    <td>
                                                        <i style="color:<?php echo $agents['passed'] == 1 ? 'green' : 'red' ?>" class="fa <?php echo $agents['passed'] == 1 ? 'fa-check' : 'fa-times' ?>"></i> 
                                                        <?php if ($agents['passed'] == 1) { ?>
                                                            <button type="button" class="btn btn-xs success" onclick="send_certificate('<?=$agents['fusionid']?>','<?=$agents['schdule_id']?>','<?=$agents['course_id']?>');" title="send mail"><i class="fa fa-envelope"></i></button>

                                                        <?php } ?>
                                                    </td>
                                                    <td>
										<?php
											
											
											$_status=$agents['status'];
											
																						
											if($_status==1) echo '<span class="label label-info">Active</span>'; 
											else if($_status==0) echo '<span class="label label-danger">Terms</span>';
											else if($_status==2) echo '<span class="label label-warning">Pre-Terms</span>';
											else if($_status==3) echo '<span class="label label-warning">Suspended</span>'; 
											else if($_status==4) echo '<span class="label label-primary">New Users</span>';
											else if($_status==5) echo '<span class="label label-warning">Bench Paid</span>';
											else if($_status==6) echo '<span class="label label-warning">Bench Unpaid</span>'; 
											else if($_status==7) echo '<span class="label label-info">Furlough</span>';
											else echo '<span class="label label-default">Deactive</span>';
										?>
										</td>

                                                </tr>
                                                <?php $i = $i + 1; ?>
                                            <?php } ?> 
                                        </tbody>
                                    </table>
                                <?php } elseif ($cat == 'F') { ?>
                                    <table class="table datatable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#
                                                <input type="checkbox" name="check_freez_all" id="check_freez_all" value="" >
                                                </th>
                                                <th scope="col">Fusion ID</th>
                                                <th scope="col">User Name</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Assigned By</th>
                                                <th scope="col">Assigned Date</th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Process</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Assigned To FID</th>
                                                <th scope="col">Assigned To</th>
                                                <th scope="col">Course Name</th>
                                                <th scope="col">User Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($freez_users as $agents) { ?>
                                                <tr>
                                                    <th scope="row" style="width:40px;"><?php echo $i; ?>&nbsp;
                                                        <input type="checkbox" class="check_freez" name="check_freez[]" id="check_freez_<?=$agents['schdule_id']?>" value="<?=$agents['schdule_id']?>" >
                                                    </th>
                                                    <td><?php echo $agents['fusionid']; ?></td>
                                                    <td><?php echo $agents['name']; ?></td>
                                                    <td><?php echo $agents['department_name']; ?></td>
                                                    <td>
                                                        <?php
                                                        preg_match("/(?<=User:).*?(?=FID)/", $agents['assign_log'], $assign_by);
                                                        echo $assign_by[0];
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                        preg_match("/(?<=Date: ).*?(?= RemoteIP)/", $agents['assign_log'], $assign_Date);
                                                        echo $assign_Date[0];
                                                        ?></td>
                                                    <td><?php echo get_client_name_by_user_id($agents['agent_id']); ?></td>
                                                    <td><?php echo get_process_name_by_user_id($agents['agent_id']); ?></td>
                                                    <td><?php echo $agents['office_id']; ?></td>
                                                    <td><?php echo $agents['assigned_to_fusionid']; ?></td>
                                                    <td><?php echo $agents['assigned_to']; ?></td>
                                                    <td><?php echo $agents['course_name']; ?></td> 

                                                    <td>
                                                        <i style="color:red;font-size: 30px;cursor: pointer;" onclick="unfreez_user('<?=$agents['schdule_id']?>');" title="click to un-freeze" class="fa fa-lock"></i>
                                                        </td>
                                                        <td>
										<?php
											
											
											$_status=$agents['status'];
											
																						
											if($_status==1) echo '<span class="label label-info">Active</span>'; 
											else if($_status==0) echo '<span class="label label-danger">Terms</span>';
											else if($_status==2) echo '<span class="label label-warning">Pre-Terms</span>';
											else if($_status==3) echo '<span class="label label-warning">Suspended</span>'; 
											else if($_status==4) echo '<span class="label label-primary">New Users</span>';
											else if($_status==5) echo '<span class="label label-warning">Bench Paid</span>';
											else if($_status==6) echo '<span class="label label-warning">Bench Unpaid</span>'; 
											else if($_status==7) echo '<span class="label label-info">Furlough</span>';
											else echo '<span class="label label-default">Deactive</span>';
										?>
										</td>
                                                </tr>
                                                <?php $i = $i + 1; ?>
                                            <?php } ?> 
                                        </tbody>
                                    </table>
                                    </div>
                                <?php }?>
                            </div>
                        </div>

                    </div><!-- .widget-body -->
                </div><!-- .widget -->
            </div>


            <!-- END DataTable -->	
        </div><!-- .row -->
    </section>
</div><!-- .wrap -->

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script >
    $(document).ready(function () {
    $('.datatable').DataTable();
});
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#multiselectwithsearch').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});
</script>