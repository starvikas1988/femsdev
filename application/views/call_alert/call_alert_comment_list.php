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

/**************************************** */
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
.model-header{
    padding: 0px;
}
/************************************************** */
</style>

<div class="wrap">
    <section class="app-content">
<div class="row">
    
<div class="row pos">
    <div class="col-md-12">
               <div class="card mb-4">
                         <div class="card-body ">
                                <table id="example" class="table table-striped">
                         <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Location</th>
                                        <th>Description</th>
                                        <th>Remarks</th>
                                        <th>Final statement</th>
                                        <th>Docs</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              
                                  <tbody>
                                <?php 
                                $i=1;
                                foreach($call_alert_list as $key=>$rows){ ?>
                                    <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $rows['call_alert_date'];?></td>
                                    <td><?php echo $rows['type'];?></td>
                                    <td><?php echo $rows['location'];?></td>
                                    <td><?php echo $rows['Comment'];?></td>
                                    <td><?php echo $rows['comments'];?></td>
                                    <td><?php echo $rows['final_comment'];?></td>
                                    <td><a href="<?php echo base_url().'uploads/call_alert/'.$rows['docs'];?>" target="_blank">Documents</a></td>
                                    <td>
                                        <?php if($rows['call_alert_status']=='P'){ echo 'Pending for approval';}?>
                                        <?php if($rows['call_alert_status']=='R'){ echo 'Send for review';}?>
                                        <?php if($rows['call_alert_status']=='A'){ echo 'Approve';}?>
                                    </td>
                                    <td>
                                    <?php /*if($rows['call_alert_status']=='Completed'){?>
                                    <span style="color:red">Completed</span>
                                    <?php }elseif($rows['call_alert_status']=='Holding'){ ?>
                                        <a class="btn btn-success btn-xs dropCandidateBtn" onclick="make_pending('<?php echo $rows['call_alert_id'];?>','Pending');">Pending</a>
                                    <?php }elseif($rows['call_alert_status']=='Pending'){ ?>
                                        <a class="btn btn-warning btn-xs dropCandidateBtn" onclick="make_pending('<?php echo $rows['call_alert_id'];?>','Holding');">Holding</a>&nbsp;
                                        <a class="btn btn-danger btn-xs dropCandidateBtn" onclick="make_pending('<?php echo $rows['call_alert_id'];?>','Completed');">Completed</a>   
                                     <?php } */
                                     //echo'<br>====>'.$rows['approve_status'];echo'<br>*******'.$rows['call_alert_status'];
                                     if($rows['approve_status']!='A'){
                                        if($rows['call_alert_status']=='P'){
                                     ?>  
                                       <a class="btn btn-success btn-xs dropCandidateBtn" onclick="change_status('<?php echo $rows['commid'];?>','<?php echo $rows['call_alert_id'];?>','A');">Approval</a> 
                                    <a class="btn btn-success btn-xs dropCandidateBtn" onclick="change_status('<?php echo $rows['commid'];?>','<?php echo $rows['call_alert_id'];?>','R');">Send for review</a> 
                                    <?php } }?>
                                    </td>
                                    </tr>
                                 <?php 
                                 $i++;
                                } ?> 
                                <tr>
                                    <td colspan="9">
                                                                       
                                    </td>
                                </tr>  
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
       <!---------------Popup  for doc upload-------------------->
<div class="modal fade" id="approve_status_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="frmdoc" id="frmdoc" action="<?php echo base_url(); ?>'call_alert/approve_status" data-toggle="validator" method='POST' enctype="multipart/form-data">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span id="msg_rest" style="color:red;"></span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="call_alert_id" name="call_alert_id" class="form-control">
                    <input type="hidden" id="id" name="id" class="form-control">
                    <input type="hidden" id="status" name="status" class="form-control">
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
                buttons: [ 'excel' ]
            } );
        
            table.buttons().container()
                .appendTo( '#example_wrapper .col-md-6:eq(0)' );
        } );

    function make_pending(id,status){
       // alert(id+'====='+status);
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>call_alert/update_status',
            data:'id='+id+'&status='+status,
            success:function(res){
                if(res==1){
                    alert('Data Updated Successfully');
                    location.reload();
                }
            }

        });
        
    }
    
    function change_status(id,call_alertid,status){
        $('#call_alert_id').val(call_alertid);
        $('#id').val(id);
        $('#status').val(status);
        $('#approve_status_form').modal('show');
        /*$.ajax({
            type:'POST',
            url:'<?php echo base_url();?>call_alert/approve_status',
            data:'id='+id+'&call_alertid='+call_alertid+'&status='+status,
            success:function(res){
                if(res==1){
                    alert('Data Updated Successfully');
                    location.reload();
                }
            }

        });*/
    }
    $(document).ready(function (e) {
    $("#frmdoc").on('submit',(function(e) {
    e.preventDefault();
    var data = new FormData(this);
    
        $.ajax({
            url: '<?php echo base_url(); ?>call_alert/approve_status',
            type: 'POST',
            data:  data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res)
            {
                console.log(res);
                if(res=='failed'){
                    alert('Failed');
                }else{
                //$('#doc').val('');
                $('#comments').val('');
                alert('Successfully Done');
                location.reload();
                }
            }
        });   
       
    }));
});
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