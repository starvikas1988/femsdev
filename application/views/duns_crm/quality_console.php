<link href="<?php echo base_url() ?>assets/css/data-table-export/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/css/data-table-export/css/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<style>
    .btn-sm{
        padding: 2px 5px;
    }
    .scrollheightdiv{
        max-height:600px;
        overflow-y:scroll;
    }
    #table-responsive{
        overflow:auto;
    }
    .tab_hed{
        color:#000;
    }
    #default_datatable_length{
        float:left;
    }
    #default_datatable_filter{
        float:right;
    }
    /*start new custom 25.05.2022*/
.common-top {
    width: 100%;
    margin-top: 10px;
    float: left;
}
.file-upload {
    width: 100%;
    margin: 10px 0 0 0;
}
.file-upload .form-control:focus {
    outline: none;
    box-shadow: none;
}
.modal-scroll {
    width: 100%;
    height: 400px;
    overflow-y: scroll;
}
.modal .modal-header {
    background: #188ae2;
    color: #fff;
}
.modal .close {
    width: 35px;
    height: 35px;
    background: #72b8ed;
    line-height: 35px;
    border-radius: 50%;
    position: absolute;
    right: -9px;
    top: -16px;
    opacity: 1;
    color: #fff;
    transition: all 0.5s ease-in-out 0s;
}
.modal .close:hover {
    background: #5ea5db;
}
.modal .table-responsive {
    padding-right: 10px;
    overflow: inherit;
}
.modal .form-inline .form-control {
    min-width: 100%;
}
.bg-success {
    transition: all 0.5s ease-in-out 0s;
}
.bg-success:hover {
    background: #0eb15e;
}
/*end new custom 25.05.2022*/

.dt-buttons {
	margin:0;
}
.buttons-excel span {
	display:none;
}
.buttons-excel {
	background:#337ab7!important;
	color:#fff!important;
	transition:all 0.5s ease-in-out 0s;
}
.buttons-excel:hover {
	background:#174e7c!important;
	border-color: #174e7c!important;
}
.buttons-excel:after {
	content:"Download Report";
}
.btn-new{
width: 150px;
padding: 10px;
border-radius: 3px;
}
.form-control{
border-radius: 3px;
}
</style>

<div class="wrap">
    <section class="app-content">
        <div class="row">

            <div class="col-md-12">
                <div class="widget">
                    <header class="widget-header">
                        <h4 class="widget-title"><i class="fa fa-calendar"></i> All Record Data</h4>
                    </header>
                    <hr class="widget-separator"/>
                    <div class="widget-body clearfix">
                    <form autocomplete="off" method="GET" >
                        <div class="row">	
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="form-control" name="client_id" id="client_id" required>
                                        <option value="">Please Select</option>
                                        <?php echo duns_dropdown_3d_options($duns_clients_list, 'id', 'name', $client_id, ''); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input type="text" class="form-control qcDatePick" name="search_from" id="search_from" value="<?php echo date('Y-m-d', strtotime($search_from)); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input type="text" class="form-control qcDatePick" name="search_to" id="search_to" value="<?php echo date('Y-m-d', strtotime($search_to)); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Assign To</label>
                                    <select class="form-control" name="assign_to" id="assign_to" required>
                                        <option value="">Please Select</option>
                                    </select>
                                </div>
                            </div>	

                            <hr/>	
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding-left: 7px;">
                                        <!-- <button type="button" id="serchBtn" class="btn btn-primary" data-type="search"><i class="fa fa-search"></i> Search</button> -->
                                        <button type="submit" class="btn btn-primary btn-new"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    </div>
                </div>

                <div class="common-top">
                <?php if(!empty($client_id)){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <header class="widget-header">
                                <h4 class="widget-title"><i class="fa fa-database"></i> All Data List 
                                <input type="hidden" name="flag" id="flag" value="true">
                                <!--<button id="downloadBtn" class="btn btn-primary btn-sm pull-right" data-type="download"><i class="fa fa-file-excel-o"></i> Download Report</button>-->
                                </h4>
                            </header>
                            <hr class="widget-separator"/>
                            <div class="widget-body clearfix">					
                                <div class="table-responsive" id="table-qc">
                                    <table id="table_list" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
                                        <thead id="dat_header">
                                            <tr>
                                                <th>SL</th>
                                                <th>Client Name</th>
                                                <th>Upload Date</th>
                                                <th>Assigned To</th>
                                                <th>Assigned Date</th>
                                                <?php $i = 0;
                                                foreach($tableheaders as $token_header){ ?>
                                                    <td><b><?php echo $token_header['reference_name']; ?></b></td>
                                                <?php 
                                                $i++;
                                                } 
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        // echo "<pre>";
                                        // print_r($response_data);
                                        $countc = 0;
                                        foreach($response_data as $token){ 
                                            $countc++;
                                        ?>
                                            <tr>
                                                <td><?php echo $countc; ?></td>
                                                <td><b><?php echo $token['client_name']; ?></b></td>
                                                <td><b><?php echo $token['du_uploaddate']; ?></b></td>
                                                <td><b><?php echo $token['assigned_to']; ?></b></td>
                                                <td><b><?php echo $token['assigned_date']; ?></b></td>
                                                <?php $i = 0;
                                                foreach($token['dynamic_fields'] as $dynamic_token){ ?>
                                                    <td><b><?php echo $dynamic_token; ?></b></td>
                                                <?php 
                                                $i++;
                                                } 
                                                ?>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>


            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    var client_id = $("#client_id").val();
    var request_url = "<?= base_url() ?>duns_crm/get_assign_agent";
    var datas = { client_id: client_id };
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        $("#assign_to").html(res);
                        
    },request_url, datas, 'text');
});
</script>