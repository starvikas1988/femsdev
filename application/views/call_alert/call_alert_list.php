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
  background: #218bdd;
  color: #fff;
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
  .filter-widget .multiselect-container {
    width: 100%;
}
.bt{
margin-top: 23px;
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
.search-btn{
width: 150px;
max-width: 100%;
padding: 9px;
border-radius: 5px;
border: none;
font-size: 15px;
transition: all 0.5s ease-in-out 0s;
display: block;
}
textarea {
    resize:none;
    height:100px!important;
}
.btn-primary {
    background:#337ab7;
    color:#fff;
    width:100px;
    padding:8px;
    transition:all 0.5s ease-in-out 0s;
}
.btn-primary:hover {
    background:#286090;
    color:#fff;
}
.btn-default {
    width:100px;
    padding:8px;
    transition:all 0.5s ease-in-out 0s;
}
.modal-footer {
    padding: 0 15px 15px 15px;
    text-align: left;
    border-top:none;
}
.modal-content .form-control {
    border: 1px solid #eee;
    transition:all 0.5s ease-in-out 0s;
}
.modal-content .form-control:hover {
    border: 1px solid #0c6bb5;
}
.modal-content .form-control:focus {
    border: 1px solid #0c6bb5;
    outline:none;
    box-shadow:none;
}
label {
    margin-bottom:5px;
}
.form-group span {
    margin:5px 0 0 0;
    display:block;
}

.modal {
    text-align: center;
}

.modal::before {
    content: "";      
    display: inline-block;
    height: 100%;    
    margin-right: -4px;
    vertical-align: middle;
}

.modal-dialog { 
    display: inline-block;  
    text-align: left;   
    vertical-align: middle;
}

/* CSS */
.button-21 {
  align-items: center;
  appearance: none;
  background-color: #3EB2FD;
  background-image: linear-gradient(1deg, #4F58FD, #149BF3 99%);
  background-size: calc(100% + 20px) calc(100% + 20px);
  border-radius: 100px;
  border-width: 0;
  box-shadow: none;
  box-sizing: border-box;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-flex;
  font-family: CircularStd,sans-serif;
  font-size: 1rem;
  height: auto;
  justify-content: center;
  line-height: 1.5;
  padding: 6px 20px;
  position: relative;
  text-align: center;
  text-decoration: none;
  transition: background-color .2s,background-position .2s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: top;
  white-space: nowrap;
}

.button-21:active,
.button-21:focus {
  outline: none;
}

.button-21:hover {
  background-position: -20px -20px;
}

.button-21:focus:not(:active) {
  box-shadow: rgba(40, 170, 255, 0.25) 0 0 0 .125em;
}
</style>

<div class="wrap">
    <section class="app-content">
<div class="row">
    <div class="col-md-12">
               <div class="card mb-4">
                            <div class="card-header">  <span class="header">Call Alert List</span>
                             </div>
                            <div class="card-body">
                              <div class="filter-widget">
                        <form name="frm" method="GET" action="">
                            <div class="row">
                             
                                <div class="col-sm-3">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Location:</label>
                                        <br>
                                        <select id="location" name="location[]" autocomplete="off" placeholder="Select Location" multiple>
                                            <?php foreach($location_list as $key=>$rows){?>
                                            <option value="<?php echo $rows['name'];?>" <?php echo (in_array($rows['name'],$location_id))?'selected':'';?>><?php echo $rows['name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Type:</label>
                                        <br>
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
                                <!--<div class="col-sm-4">-->
                                    <div class="bt">
                                        <button type="submit" class="search-btn btn-primary  mt-3"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                                    </div>
                                <!--</div>-->
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
                                                <th><!--<input type="checkbox" id="checkall" name="checkall" onclick="checkall()">-->Check</th>
                                                <th>SL</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Location</th>
                                                <th>Comment</th>
                                                <th>Contact No</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody>
                                        <?php 
                                        $i=1;
                                        foreach($call_alert_list as $key=>$rows){ ?>
                                            <tr>
                                            <td><input type="checkbox" id="checkbox<?php echo $rows['call_alert_id'];?>" name="call_alert_id[]" value="<?php echo $rows['call_alert_id'];?>" class="all_check" onclick="checkall()"></td>    
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $rows['call_alert_date'];?></td>
                                            <td><?php echo $rows['type'];?></td>
                                    <td><?php echo $rows['location'];?></td>
                                    <td><?php echo $rows['Comment'];?></td>
                                    <td><?php echo $rows['client_contact'];?></td>
                                    <td><?php echo ($rows['call_alert_status']=='')?'Waiting':(($rows['call_alert_status']=='Completed')?'Completed':$rows['call_alert_status']);?></td>
                                    <td>
                                    <?php 
                                        $call_alertID=$rows['call_alert_id'];
                                     /*if(($rows['call_alert_status']!='Completed' )&&($rows['approve_status']!='A')){
                                        if(($rows['is_doc_upload']=='0') ||(get_comment_status($call_alertID)!='A')){
                                     ?>  
                                       <a class="btn btn-success btn-xs dropCandidateBtn" onclick="change_data('<?php echo $rows['call_alert_id'];?>');">View</a> 
                                       <?php 
                                     }*/
                                       if((get_global_access()=='1')||(get_email_id_off()==$rows['emails1'])||call_l2_access()){ 
                                           /*if(($rows['is_doc_upload']=='1')&&(get_comment_status($call_alertID)=='P')){
                                           ?>
                                        <a class="btn btn-success btn-xs dropCandidateBtn" href="<?php echo base_url();?>call_alert/call_alert_comment_histroy?call_alert=<?php echo $rows['call_alert_id'];?>" target="_blank">Approval</a> 
                                      
                                       </a>
                                    <?php }} */
                                     if($rows['approve_status']!='A'){
                                        if($rows['call_alert_status']!=''){
                                        ?>
                                    <a class="btn btn-success btn-xs dropCandidateBtn" onclick="close_data('<?php echo $rows['call_alert_id'];?>');">Close</a> 
                                     <?php } ?>
                                    <a class="btn btn-danger btn-xs dropCandidateBtn" onclick="delete_data('<?php echo $rows['call_alert_id'];?>');">
                                            <i class="fa fa-times" aria-hidden="true"></i> </a>
                                    <?php }} ?>                                  
                                    </td>
                                    </tr>
                                 <?php 
                                 $i++;
                                } ?>
                                 
                                </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div id="view_det" style="display:none">
                                    
                <input type="button" name="CloseAll" id="CloseAll" Value="CloseAll" class="button-21"  onclick="close_all('closeall');">
                <input type="button" name="DeleteAll" id="DeleteAll" Value="DeleteAll" class="button-21" onclick="close_all('deleteall');">
            </div>
        </div>
       <!---------------Popup  for doc upload-------------------->
<div class="modal fade" id="upload_doc_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmdoc" id="frmdoc" action="<?php echo base_url(); ?>'call_alert/upload_docs_file" data-toggle="validator" method='POST' enctype="multipart/form-data">

                <div class="modal-header" style="padding:0;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span id="msg_rest" style="color:red;"></span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="call_alert_id" name="call_alert_id" class="form-control">
                   <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                     <option value="Pending">Pending</option>
                                   <option value="Holding">Holding</option>
                                    <option value="Completed">Completed</option>
                                </select>    
                            </div>
                        </div>
                    </div>-->
                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Upload Doc</label>
                                <input type="file" name="doc" id="doc" class="form-control" accept=".pdf,.png,.jpg,.jpeg" required="required" onchange="check_size(this);">
                                <span style="color:red;">(Upload Max File Size is 2 MB)</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>comments</label>
                                <textarea name="comments" id="comments" class="form-control" required="required" ></textarea>
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
                iDisplayLength: 50,
                stateSave: true,
                buttons: [ 'excel' ]
                
            } );
           
            table.buttons().container()
                .appendTo( '#example_wrapper .col-md-6:eq(0)' );
        } );
       /*$(document).ready(function() {
            $('#example').DataTable( {
                stateSave: true
            } );
        });*/

    
        function checkall(){
                chk="false";
                $('.all_check').each(function(){  
                is_checked=$(this)[0].checked;
                 if(is_checked)chk="true";
                });
                if(chk=='true'){
                    $('#view_det').css('display','block');
                }else{
                    $('#view_det').css('display','none');
                }
            }
           
</script>


     
        <!-- Data-table -end -->

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
</script>

 <script>
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