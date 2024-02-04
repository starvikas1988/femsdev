
<link href="<?=base_url()?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/css/search-filter/assets/js/all.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

<style>
    td{
        font-size:10px;
    }
    
    #default-datatable th{
        font-size:11px;
    }
    #default-datatable th{
        font-size:11px;
    }
    
    .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
        padding:8px;
    }
    
.dataTable-container thead {
  background: #f2f2f66e;
  color: #615a5a;
}
.btn-table{
float: right;
}
.card-header {
  background: #f1e9e933;
  border-bottom: 1px solid #cbcfd8ba;
  color: #1b1515;
  position: relative;
}
.header{
font-size: 1rem;
font-weight: 600;

}
 .table thead {
  background: #218bdd;
  color: #fff
}

table.dataTable {
margin-top: -10px !important;
}
.btn {
  width: 150px;
  margin-top: 1px;
  padding: 10px;
}
.dataTables_length{
    margin-bottom: 15px;
}
.dataTables_length .form-select
{
    background: #fff;
    border: none;
   border: 1px solid #ccc;
   border-radius: 5px;
   height: 35px!important;
}
.dataTables_wrapper .dataTables_filter input {
  height: 35px!important;
}
.file-filled input[type="file"] {
  border: 1px solid #ccc;
  display: block;
  padding-top: 8px;
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
    
.myDIV:hover + .hide {
  display: block;
  color: red;
}
.btn-download {
  width: 100px;
  margin-top: 1px;
  padding: 6px;
  float: right;
  font-size: 10px;
}
.dataTables_wrapper .buttons-excel {
    text-transform: capitalize;
    background: #337ab7;
    border:none!important;
    color: #fff;
    border-radius: 1px;
    transition:1s;
    width: 50px;
    border: none;
    padding: 8px;
    font-size: 11px;
}
.dataTables_wrapper .buttons-excel:hover{
    background: #286090!important;
    border:none!important;
    color: #fff;
}
.dataTables_wrapper .buttons-excel:focus{
    background: #286090!important;
    border:none!important;
    color: #fff!important;
}
 .dataTables_filter input{
    border-radius:1px!important;
}
.dataTables_filter input:focus{
   outline: none!important;
    
}
.dt-buttons{
    margin-bottom: 5px!important;
}
</style>

<div class="wrap">
    <section class="app-content">

<div class="row">
    <div class="col-md-6">
               <div class="card mb-4">
                <div class="card-header">  
                    <div class="col-md-6">
                        <span class="header"> Bulk Stock Import </span>
                        <button type="button" id="info-excel" class="btn btn-xs btn-new" data-toggle="modal" data-target="#myModal"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
                       
                    </div>
                    <div class="col-md-6">
                        <a href="<?=base_url()?>it_assets_import/sample_data/Stock_import_sample_formate.xlsx" type="button" class="btn btn-primary btn-download">Sample Download</a>
                    </div>
                </div>
                     <div class="card-body">
                        <form method="post" enctype="multipart/form-data" autocomplete="off" id="file_upload_it">
                        <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group file-filled ">
                                    <input type="hidden" name="import_type" value="stock" required>
                                    <label for="full_form">Upload Excel<span style="color: red">*</span></label>
                                    <input type="file" name="upload_file" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="full_form">Location<span style="color: red">*</span></label>
                                    <select class="form-control" id="it_location" name="location_name"  required="required">
                                        <option selected disabled value="">Select a location</option>
                                    <?php foreach ($location_list as $key => $value) { ?>
                                        <option value="<?php echo $value['abbr']; ?>"><?php echo $value['office_name'] ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="full_form">Stock Import Type<span style="color: red">*</span></label>
                                    <select class="form-control" id="stock_type" name="stock_type"  required="required">
                                        <option value="" selected>Select a option</option>
                                        <option value="1">New</option>
                                        <option value="2">Modification/Update</option>
                                    </select>
                                </div>
                            </div>                            
                             <div class="col-md-4">
                                 <button style="margin-top: 20px;" id="uploadButton" type="submit" class="btn btn-primary">Upload & Verify</button>
                            </div>
                        </form>
                        </div>
                     </div>
               </div>
    </div>
        <div class="col-md-6">
               <div class="card mb-4">
                <div class="card-header">  
                    <div class="col-md-3">
                        <span class="header"> Bulk Stock Assignment </span>
                        <button type="button" id="info-excel" class="btn btn-xs btn-new" data-toggle="modal" data-target="#myModal2"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
                       
                    </div>
                    <div class="col-md-9">
                        <a href="<?=base_url()?>it_assets_import/sample_data/excel_import_stock_assignment_ticketing.xlsx" type="button" class="btn btn-primary btn-download">Sample Ticketing</a>
                        <a style="margin-right: 8px;width: 105px;" href="<?=base_url()?>it_assets_import/sample_data/excel_import_stock_assignment_onboarding.xlsx" type="button" class="btn btn-primary btn-download">Sample Onboarding</a>
                        <a style="margin-right: 8px;width: 105px;" href="<?=base_url()?>it_assets_import/sample_data/excel_import_stock_assignment_jitbit.xlsx" type="button" class="btn btn-primary btn-download">Sample Jitbit</a>
                    </div>
                </div>
                     <div class="card-body">
                        <div class="row">
                            <form id="file_upload_it" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="col-md-6">
                                 <div class="form-group file-filled">
                                    <input type="hidden" name="import_type" value="assignment" required>
                                    <label for="full_form">Upload Excel<span style="color: red">*</span></label>
                                    <input type="file" name="upload_file" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="full_form">Location<span style="color: red">*</span></label>
                                    <select class="form-control" id="it_location" name="location_name"  required="required">
                                        <option selected disabled value="">Select a location</option>
                                    <?php foreach ($location_list as $key => $value) { ?>
                                        <option value="<?php echo $value['abbr']; ?>"><?php echo $value['office_name'] ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>                                                        
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="full_form">Assignment Types<span style="color: red">*</span></label>
                                    <select class="form-control" id="req_type" name="req_type"  required="required">
                                        <option value="" selected>Select a option</option>
                                        <option value="1">Onboding Recruitment (DFR)</option>
                                        <option value="2">IT Support (Ticketing System)</option>
                                        <option value="3">IT Support (Jitbit)</option>
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-4">
                                 <button style="margin-top: 20px;" id="uploadButton" type="submit" class="btn btn-primary">Upload & Verify</button>
                            </div>
                            </form>
                        </div>
                     </div>
               </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
               <div class="card mb-4">
                            <div class="card-header">  <span class="header">Excel Validation Details</span>
                </div>
                            <div class="card-body">
                                <?php if ($excel_error_result !== false) { 
                                    $count = count($excel_error_result);
                                ?>

                                <table id="example" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Excel SL</th>
                                        <th>Excel Issues</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                    <?php
                                    $c= 1;
                                    foreach ($excel_error_result as $key => $value) { ?>
                                        <tr> 
                                            <td><?=$c?></td>
                                            <td><?=$key?></td>
                                            <td style="color: red;">
                                            <?php
                                                foreach ($excel_error_result[$key] as $value) {
                                                    echo $value;
                                                }
                                            ?>
                                            </td>
                                        </tr>
                                    <?php $c++; } ?>
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
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Info</h4>
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
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal Add -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Info</h4>
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
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

     <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

       <script>
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ]
        } );
    } );
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


        $('INPUT[type="file"]').change(function () {
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
       
