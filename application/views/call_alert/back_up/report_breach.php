<link href="<?=base_url()?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/css/search-filter/assets/js/all.min.js"></script>
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<style>
    .white_area {
        width:100%;
        background:#fff;
        padding:10px;
        border-radius:5px;
    }
    hr {
        margin:10px 0;
    }
    .common_top {
        width:100%;
        margin:10px 0 0 0;
    }
    .table-widget th {
        background:#188ae2;
        color:#fff;
        padding:6px!important;
    }
    .table-widget td {
        padding:6px!important;
    }
    .buttons-excel {
        background: #337ab7!important;
        color: #fff!important;
        border: none;
        text-transform: capitalize;
        box-shadow: none;
        letter-spacing: 1px;
        font-size: 14px;
    }
    .buttons-excel:hover {
        border: none;
        background: #286090 !important;
        box-shadow: none;
        color: #fff!important;
    }
</style>

<div class="wrap">
    <div class="widget">
        <div class="widget-body">
            <h4>Filter Heading</h4>
            <hr>
            <form name="frm" id="frm" method="get" action="<?php echo base_url();?>call_alert/report_breach ">
            <div class="common_top">
                <div class="filter-widget">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">Location:</label>                                       
                                <select id="location" name="location[]" autocomplete="off" placeholder="Select Location" multiple>
                                    <?php foreach($location_list as $key=>$rows){?>
                                    <option value="<?php echo $rows['name'];?>" <?php echo (in_array($rows['name'],$location_id))?'selected':'';?>><?php echo $rows['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">Type:</label>                                       
                                <select id="type" name="type[]" autocomplete="off" placeholder="Select Type" multiple>
                                        <?php foreach($type_list as $key=>$rows){?>
                                            <option value="<?php echo $rows['name'];?>" <?php echo (in_array($rows['name'],$type_id))?'selected':'';?>><?php echo $rows['name'];?></option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">From Date:</label>                                       
                                <input type="date" id="from_date" name="from_date" class="form-control hasDatepicker" value="<?php echo $frm_date;?>">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">To Date:</label>                                       
                                <input type="date" id="to_date" name="to_date" class="form-control hasDatepicker" value="<?php echo $to_date;?>" >
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="submit-btn">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        Search
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="common_top">
        <div class="widget">
            <div class="widget-body">
                <div class="table-widget">
                <table id="example" class="table table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Comment</th>
                            <th>Email IDs</th>
                            <th>Supervisor's Email IDs</th>
                            <th>Document Upload</th>
                            <th>Breach Days</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=0;
                        foreach($call_alert_list as $key=>$rows){ 
                        $i++;    
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $rows['call_alert_date'];?></td>
                            <td><?php echo $rows['type'];?></td>
                            <td><?php echo $rows['location'];?></td>
                            <td><?php echo $rows['Comment'];?></td>
                            <td><?php echo $rows['emails'];?></td>
                            <td><?php echo $rows['emails1'];?></td>
                            <td><?php echo ($rows['is_doc_upload']==1)?'Yes':'No';?></td>
                            <td>
                                <?php 
                                    $dt1=date_create_from_format('Y-m-d', $breach_date);
                                    $dt2=date_create_from_format('Y-m-d', $rows['call_alert_date']);
                                    $dff= (array)date_diff($dt1,$dt2);
                                    echo  $dff['days'];
                                ?>
                            </td>
                            <td><?php echo ($rows['approve_status']=='P')?'Pending':'Approve';?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?=base_url()?>assets/css/assets/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/css/assets/js/dataTables.bootstrap5.min.js"></script>
<script src="<?=base_url()?>assets/css/assets/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/css/assets/js/buttons.bootstrap5.min.js"></script>
<script src="<?=base_url()?>assets/css/assets/js/jszip.min.js"></script>
<script src="<?=base_url()?>assets/css/assets/js/pdfmake.min.js"></script>
<script src="<?=base_url()?>assets/css/assets/js/vfs_fonts.js"></script>
<script src="<?=base_url()?>assets/css/assets/js/buttons.html5.min.js"></script>
<script src="<?=base_url()?>assets/css/assets/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>assets/css/assets/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            lengthChange: false,
            buttons: [ 'excel' ]
        } );
    
        table.buttons().container()
            .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  });
</script>

<script>
    $(function() {
        $('#multiselect').multiselect();
        $('#location').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
    $(function() {
        $('#multiselect').multiselect();
        $('#type').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>