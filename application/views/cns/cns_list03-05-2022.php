<link href="<?=base_url()?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/css/search-filter/assets/js/all.min.js"></script>
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />

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
		padding:3px;
	}
	.modal .close {
    color: #fff;
    text-shadow: none;
    opacity: 1;
    position: absolute;
    top: -15px;
    right: -14px;
    width: 35px;
    height: 35px;
    background: #0c6bb5;
    border-radius: 50%;
    transition: all 0.5s ease-in-out 0s;
}
.modal-title {
  color: #fff;
  font-weight: 700;
}
.modal-btn {
  width: 100px;
  max-width: 100%;
  padding: 10px;
  background: #4650dd;
  border-radius: 20px;
  color: #fff;
  border: none;
  font-size: 15px;
  transition: all 0.5s ease-in-out 0s;
  display: block;
}
.modal-btn:hover {
  background: #001cff;
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
}
.header{
font-size: 1rem;
font-weight: 600;

}
 .table thead {
  background: #f3cf61;
  color: #233650;
}


.btn-check:focus + .btn-warning, .btn-warning:focus {

    box-shadow: none;

}
.pading{
padding: 5px;
}
.edit-btn {
  width: 30px;
  height: 30px;
 color: #fff !important;
  border-radius: 50%;
  text-align: center;
  display: inline-block;
  transition: all 0.5s ease-in-out 0s;
}
.dt-buttons {
float: left;
}
table.dataTable {
margin-top: -10px !important;
}
.buttons-excel span {
display:none;
}
.buttons-excel:after {
content:"Export";
}
.buttons-excel {
  background: #5969ff!important;
  color: #fff!important;
  border: none;
  text-transform: uppercase;
  box-shadow: none;
  letter-spacing: 1px;
  font-size: 14px;
}
.buttons-excel:focus {
            border:none;
     background: #4656e9;
     box-shadow: none;
}
.buttons-excel:active:focus{
box-shadow: none;
}
.buttons-excel:hover {
        border:none;
  background: #0a20ef !important;
    box-shadow: none;
    color: #fff!important;
  }
  .filter-widget .multiselect-container {
    width: 100%;
}
.bt{
margin-top: 22px;
}
div.dataTables_wrapper div.dataTables_filter input {
  width: 200px;
  height: 40px;
}
.fa-search{
margin-right: 5px;
}
.pos{
position: relative;
top: -10px;
}
</style>

<div class="wrap">
    <section class="app-content">
<div class="row">
    <div class="col-md-12">
               <div class="card mb-4">
                            <div class="card-header">  <span class="header">CNS List</span>
                             </div>
                            <div class="card-body">
                              <div class="filter-widget">
                        <form>
                            <div class="row">
                             
                                <div class="col-sm-4">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Demo:</label>
                                        <br>
                                        <select id="loaction" name="" autocomplete="off" placeholder="Select Location" multiple>
                                            <option>Demo</option>
                                            <option>Demo</option>
                                            <option>Demo</option>
                                            <option>Demo</option>
                                        </select>
                                    </div>
                                </div>
                                   <div class="col-sm-4">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Demo:</label>
                                        <br>
                                        <select id="loaction1" name="" autocomplete="off" placeholder="Select Location" multiple>
                                            <option>Demo</option>
                                            <option>Demo</option>
                                            <option>Demo</option>
                                            <option>Demo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="bt">
                                        <button type="submit" class="blue-btn  mt-3"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                            </div>
                        </div>
                    </div>
                </div>

<div class="row pos">
    <div class="col-md-12">
               <div class="card mb-4">
                         <div class="card-body ">
                                <table id="example" class="table table-striped">
                         <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              
                                  <tbody>
                        <tr>
                            <td>Demo</td>
                            <td>Demo</td>
                           <td>Demo</td>
                            <td>Demo</td>
                        </tr>
                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
} );
        </script>
        <!-- Data-table -end -->

        <script>
$(function() {
    $('#multiselect').multiselect();
    $('#loaction').multiselect({
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
    $('#loaction1').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        filterPlaceholder: 'Search for something...'
    });
});
</script>