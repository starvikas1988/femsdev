
<link href="<?=base_url()?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/css/search-filter/assets/js/all.min.js"></script>
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<!-- <script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script> -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>

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
 position: relative;
  bottom: -5px;
}
 .table thead {
  background: #218bdd;
  color: #fff
}
/*#f3cf61*/

.btn-check:focus + .btn-warning, .btn-warning:focus {

    box-shadow: none;

}
.btn-warning:hover {
    color: #fff;
    background-color: #218bdd;
    border-color: #218bdd;
}
.btn-warning {
    color: #fff;
    background-color: #218bdd;
    border-color: #218bdd;
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
  background: #337ab7!important;
  color: #fff!important;
  border: none;
  text-transform: capitalize;
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
  background: #286090 !important;
    box-shadow: none;
    color: #fff!important;
  }
  div.dataTables_wrapper div.dataTables_filter input {
  width: 200px;

}
.pop-btn{
  width: 100px;
  padding: 10px;
  color: #fff;
  font-size: 13px;
  letter-spacing: 0.5px;
  transition: all 0.5s ease-in-out 0s;
  border: none;
  border-radius: 5px;
}
.modal-header {
background-color: #188ae2;
}
#location_edit
{
    height: 100px;
}

</style>

<div class="wrap">
    <section class="app-content">
<div class="row">
    <div class="col-md-12">
               <div class="card mb-4">
                            <div class="card-header">  <span class="header">Location Access - Settings & View</span>
                    <button type="button" id='btn_add_category' class="btn btn-primary btn-sm btn-table" data-toggle="modal" data-target="#modalAddCnsLocation ">Add Access</button>
                </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped">
                         <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Location</th>
                                        <th>Fusion ID</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              
                                  <tbody>
                                <?php
                                    $i=1;
                                    foreach($access_list as $row): 
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $row['location'] ?></td>
                                        <td><?php echo $row['fusion_id'] ?></td>
                                        <td>  <label class="btn status_btn pb-1"><?php echo ($row['status']=='A')?'Active':'Inactive'; ?></label></td>
                                        <td>
                                            <button data-toggle="modal" data-target="#modalEditCnsLocation" onclick="get_cns_location_data('<?php echo $row['id']; ?>','<?php echo $row['fusion_id']; ?>','<?php echo $row['location']; ?>')" type="button" class="btn btn-xs btn-primary edit-btn" title="Edit Location"><i class="fa fa-edit"></i></button>
                                            <button onclick="delete_cns_location(<?php echo $row['id']; ?>)" type="button" class="btn btn-xs btn-danger edit-btn" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

<div class="modal fade" id="modalAddCnsLocation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">        
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" style="display:inline;">Location Access</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body filter-widget">
                <form method="post" action="<?php echo base_url()?>cns/add_location_access">
                    <div class="form-group">
                        <label for="full_form">Location Access</label>
                        <select name="location[]" id="location_access" class="form-control" multiple>
                           <?php foreach($location_list as $key=>$rows){ ?> 
                            <option value="<?php echo $rows['name'];?>"><?php echo $rows['name'];?></option>
                           <?php } ?>
                        </select>    
                    </div>
                    <div class="form-group">
                        <label for="full_form">Fusion ID</label>
                        <input type="text" name="fusion_id" class="form-control" id="fusion_id">
                    </div>
                    
                    <div class="form-group text-left">
                        <button Type="button" id="add_button" class="btn-primary pop-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditCnsLocation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">        
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" style="display:inline;">Edit Location Access</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body filter-widget">
                <form method="post" action="<?php echo base_url()?>cns/edit_location_access">
                    <input type="hidden" name="id" id="edit_id" value="<?php echo $id;?>">
                    <div class="form-group">
                        <label for="full_form">Location Access</label>
                        <select name="location_edit[]" id="location_edit" class="form-control" multiple>
                           
                        </select>    
                    </div>
                    <div class="form-group">
                        <label for="full_form">Fusion ID</label>
                        <input type="text" name="fusion_id_edit" class="form-control" id="fusion_id_edit" value="<?php echo $fusion_id;?>">
                    </div>
                    <div class="form-group text-left">
                        <button type="button" id="edit_button" class="btn-primary pop-btn">Submit</button>
                    </div>
                </form>
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
} );
        </script>
        <!-- Data-table -end -->

        <script>
$(function() {  
 $('#multiselect').multiselect();

 $('#location_access').multiselect({
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
 $select=$('#location_edit').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });*/

function get_cns_location_data(id,fusion_id,location){
        $('#edit_id').val(id);
        $('#fusion_id_edit').val(fusion_id);
       /* var str_array_skills = location.split(',');

        jQuery.each(str_array_skills, function( i, val ) {
            $("#location_edit option[value='"+val+"']").attr("selected","selected");
        });*/
        $.ajax({
                type:'GET',
                url:'<?php echo base_url();?>/cns/get_edit_location',
                data:'id='+id+'&fusion_id='+fusion_id+'&location='+location,
                success:function(res){
                   /* if(res=='1'){
                        alert('Data Deleted Successfully');
                    location.reload();
                    }*/
                    $('#location_edit').html(res);
                }
            });
       
        
    }
</script>