<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>     <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>


<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	.label {
		/*padding: .7em .6em;*/
	}
	.select-widget .form-control {
		border:1px solid #ddd;
	}
	.select-widget .form-control:hover {
		border:1px solid #ddd;
	}
	.select-widget .form-control:focus {
		border:1px solid #ddd;
		outline:none;
		box-shadow:none;
	}
	.textarea-widget textarea {
		border:1px solid #ddd;
	}
	.textarea-widget textarea:hover {
		border: 1px solid #188ae2!important;
	}
	.textarea-widget textarea:focus {
		border: 1px solid #188ae2!important;
		outline:none!important;
		box-shadow:none!important;
	}	
	.modal-design .btn-group, .btn-group-vertical {
		width: 100%!important;
	}
	.filter-widget .multiselect-container {
width: 100%!important;
}
.header{
	padding: 0 0 9px 0;
}
.table .select-box {
  min-width: 100px!important;
}
.table{
	width: 100%;
display: block;
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
	background:#1fc929;
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
    margin:0 0 10px 0;
}

.track .step.active .text {
	font-weight: 400;
	color: #000
}

.track .text {
	display: block;
}
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-header">
						<h4 class="widget-title">
							Search Tickets
							<a class="btn btn-success btn-sm add-ticket pull-right" href="#" data-toggle="modal" data-target="#addTicketModel" title="Add Ticket" style='font-size:10px; margin-left:20px;'>Add Ticket</a>
						</h4>
					</div>
					<hr class="widget-separator">
					<div class="widget-body">						
						<div class="filter-widget">
						<div class="row">
								<form method="GET" action="<?php echo base_url()?>it_assets_support">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Start date</label>
											<input value="<?=$start_date?>" name="start_date" value="" type="date" class="form-control" id="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>End date</label>
											<input value="<?=$end_date?>" name="end_date" value="" type="date" class="form-control" id="">
										</div>
									</div>
								<?php if($check_hod!=false){?>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Search by Ticket ID</label>
											<input value="<?=$ticket_id?>" name="ticket_id" value="" type="text" placeholder="Enter Ticket ID" class="form-control" id="">										
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Search by MWP ID</label>
											<input value="<?=$fusion_id?>" name="fusion_id" value="" type="text" placeholder="Enter MWP ID" class="form-control" id="">										
										</div>
									</div>
								<?php } ?>
									 <div class="col-sm-3">
										<div class="form-group">
											<label>Status</label>
													<select name="hod_action" id="select-view" class="select-box form-control">
													<option value="">All</option>
													<option value="1" <?php if($hod_action==1) echo "selected"?>>Pending</option>
													<option value="2" <?php if($hod_action==2) echo "selected"?>>HOD Approve Pending</option>
													<option value ="7" <?php if($hod_action==7) echo "selected"?>>HOD Approved</option>
													<option value ="6" <?php if($hod_action==6) echo "selected"?>>HOD Rejected</option>
													<option value ="8" <?php if($hod_action==8) echo "selected"?>>IT Rejected</option>
													<option value ="9" <?php if($hod_action==9) echo "selected"?>>Close</option>
													<option value ="10" <?php if($hod_action==10) echo "selected"?>>Cancel</option>


											</select>											
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Request Type</label>
												<select name="request_type" id="select-view" class="select-box form-control">
												<option value="">All</option>
												<option value="1" <?php if($request_type==1) echo "selected"?>>New Asset</option>
												<option value="2" <?php if($request_type==2) echo "selected"?>>Existing Assets</option>
											</select>										
										</div>
									</div>
								<?php if($check_hod!=false){?>
									<div class="col-sm-3">
										<div class="form-group">
											<label>View Ticket</label>
												<select name="tic_view_type" id="tic_view_type" class="select-box form-control">
												<option value="1" <?php if($tic_view_type==1) echo "selected"?>>My Team Ticket</option>
												<option value="2" <?php if($tic_view_type==2) echo "selected"?>>My Ticket</option>
											</select>										
										</div>
									</div>
									<?php } ?>									
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" class="submit-btn">
												<i class="fa fa-search" aria-hidden="true"></i>
												Search
											</button>
										</div>
									</div>
									</div>									 
							
								</form>
							</div>
						</div>
					</div>
				</div>
				
				</div>
					<div class="common-top">
					<div class="widget">
					
						<div class="widget-body common-position">
								<div class="header">
							<h4>Total Tickets Found <?=count($ticket_data)?></h4>
						</div>
							<div class="table-bg">
								<table id="example" class="table table-bordered table-responsive table-striped">
									<thead>
										<th>Sl No.</th>
										<th>Fusion Id</th>
										<th>Ticket Id</th>
										<th>Name</th>
										<th>Department</th>
										<th>Role</th>
										<th>Location</th>	
										<th>Request Type</th>
										<th>Issue Type</th>
										<th>Request For</th>
										<th>Raised Date</th>
										<th>Reason</th>
										<th>Current Status</th>
										<th>Action</th>
										<?php if($check_hod!=false){?>
										<th>HOD Action</th>
										<?php } ?>
									</thead>
									<tbody>
									
									<?php $c=1;
								foreach ($ticket_data as $value) { $status = $value['tic_status'];
									if($value['req_type']=='1')$req='new asset';
									else $req='existing asset';

		                            if($status == 1) $stat = '<label class="label label-warning">Pending</label>';
		                            elseif($status == 2) $stat = '<label class="label label-danger">Reject</label>';
		                            elseif($status == 4) $stat = '<label class="label label-info">On Hold/In-progress</label>';
		                            elseif($status == 5 && $value['hod_approval'] == '') $stat = '<label class="label label-primary">HOD Approve Pending</label>';
		                            elseif($status == 5 && $value['hod_approval'] == 1) $stat = '<label class="label label-success">HOD Approved</label>';
		                            elseif($status == 6 && $value['hod_approval'] == 2) $stat = '<label class="label label-danger">HOD Rejected</label>';
		                            elseif($status == 7) $stat = '<label class="label label-success">Close	</label>';
		                            elseif($status == 3) $stat = '<label class="label label-danger">Cancel</label>';
                            	?>
										<tr>		
										<td><strong><?=$c?></strong></td>
										<td><?=$value['fusion_id']?></td>
										<td><?=$value['ticket']?></td>
										<td><?=$value['fname'].$value['lname']?></td>
										<td><?=$value['shname']?></td>
										<td><?=$value['role_name']?></td>
										<td><?=$value['location']?></td>
										<td><?=$req?></td>
										<td><?php
										if($value['catname'] !='') echo $value['catname'];
										else echo "Others"; ?></td>
										<td><?=$value['name']?></td>
										<td><?=$value['raised_date']?></td>
										<td><?=$value['remarks']?></td>
										<td><?=$stat?></td>
										<td>

									<?php 
									 if($value['tic_status']==1 && get_user_id()==$value['user_id']){ ?>
										<button style="margin-top: 4px;" type="button" class="btn btn-danger" id="<?=$value['tid']?>" onclick="cancel_ticket(this.id)">Cancel</button>
									<?php } ?>

										<a style="margin-top: 4px;" type="button" class="tracking_new view_ticket_his btn btn-primary" title="View Tracker" id="<?=$value['tid']?>"><i class="fa fa-eye" aria-hidden="true"></i></a>							
									</td>

										<?php if($check_hod!=false){?>
										<td>
											<?php if($value['tic_status']=='5' && $value['hod_approval']==''){ ?>
											<select class="select-box form-control "  id="ap_res"data-toggle="modal"onchange="open_modal(<?=$value['tid']?>,'<?=$value['ticket']?>')" >
											<option selected>Please Choose</option>
											<option value="1">Approve</option>
											<option value="2">Reject</option>
											</select>	
											<?php } ?>			
										</td>
										<?php }?>
										
										</tr>

									<?php 
									$c++;} 
										
								?>
									
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
		</div>
					
		<div id="myModal" class="modal fade modal-design" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Remarks</h4>

      </div>
        <div class="modal-body">
			<div class="filter-widget">
      <div class="row">
      	<div class="col-md-12">
      		<div class="form-group">
							<label >Enter Remarks </label> 
							
							<input type="text" id="valid_reason" name="reason" class="form-control">  
							<input type = "hidden" id="result">
							<input type = "hidden" id="approval_val">
							<input type = "hidden" id="ticket_id">                          
							                
						</div>
      		
      	</div>
      </div>
  </div>
</div>
      <div class="modal-footer">
        <button type="button" class="submit-btn" data-dismiss="modal" id="add_reason" >Submit</button>
        <button type="button" class="pop-danger-btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>				

<!---------------Add Ticket Model-------------------->
<div class="modal fade in modal-design" id="addTicketModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <form action="<?php echo base_url();?>It_assets_support/generate_ticket" method="POST">
            
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Add New Ticket</h4>
        </div>
        <div class="modal-body">
			<div class="filter-widget">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="form-check-label" for="category"> Request Type <span style="color: red">*</span></label>
							<select name="req_type" class="select-box form-control" id="req_type" required>
							<option value="" selected>Select a option</option>
							<?php if($ext_assets_check != false): ?>
							<option value="2">For existing assets</option>
							<?php endif; ?>
							<option value="1">For new request</option>
							</select>                    
						</div>
					</div>
					<div class="col-md-3 get_assets_category_data" id="new_assets_check" style="display: none;">
						<div class="form-group">
							<label style="display:block"> New Assets <span style="color: red">*</span></label>                                 
							<select class="select-box form-control assets_id" name="asset_new" id="new_asset" >
								<option value="" selected >Select Assets</option>
								<?php
									$ext_assign_ast_id = array();
									if ($ext_assets_check != false) { 
										for($i=0;$i < count($ext_assets_check); $i++) {
											$ext_assign_ast_id[] = $ext_assets_check[$i]['assets_id'];
										}
									}

								 	foreach($new_assets_list as $loc): $assest_id = $loc['id'];
								 		if(!in_array($assest_id,$ext_assign_ast_id)) { ?>
									<option value="<?php echo $loc['id']; ?>" ><?php echo $loc['name']; ?></option>

								 <?php } endforeach; ?>
							</select>                      
						</div>
					</div>
					<?php if ($ext_assets_check != false): ?>
					<div class="col-md-3 get_assets_category_data" id="exe_assets_check" style="display: none;">
						<div class="form-group">
							<label style="display:block">Existing Assets <span style="color: red">*</span></label> 
							<select name="asset" class="select-box form-control assets_id" id="exe_assets" >
							<option value="">Select Assets</option>
							<?php $c=0; foreach ($ext_assets_check as $value) { $c+=1; ?>
							<option value="<?=$value['assets_id']?>"><?=$value['assets_name']?></option>
							<?php } ?>
							<!-- <option value="others">Others</option> -->
							</select>                                
							                
						</div>
					</div>
					<?php endif; ?>

					<div class="col-md-3">
						<div class="form-group">
							<label style="display:block">Issues <span style="color: red">*</span></label> 
							<select name="category_id" class="select-box form-control" id="assets_category_id" >
							<option value="">Select Issues</option>
							<option value="others">Others</option>	
							
						</select>                                
							                
						</div>
					</div>					
					
				 <div class="row" style="padding-top:0px;">
					<div class="col-md-12">
						<div class="form-group textarea-widget">
							<label> Reason of asset submission  <span style="color: red">*</span></label>
							<textarea style="width: 100%;height: auto;padding: 10px;height: 100px;transition: all 0.5s ease-in-out 0s;border: 1px solid #ddd;resize: none;" id="details_ticket" name="details" required></textarea>
						</div>
					</div>
				</div>
			</div>			
        </div>
      </div>
        
        <div class="modal-footer">
            <button type="submit" class="submit-btn" id="sub_btn">Submit</button>
            <button type="button" class="pop-danger-btn" data-dismiss="modal">Cancel</button>
        </div>
        
        </form>
        
        </div>
    </div>
</div>

<!-----------------------   reason for approve or reject modal   --------------------->

<div id="modal_track" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reject Ticket</h4>
      </div>
      <form id="reject_ticket">
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <input type="hidden" id="ticket_id" name="ticket_id" value="">
                <div class="form-group">
                    <label>Reject Reason</label>
                    <textarea id="reject_reason" maxlength="1000" name="reject_reason" placeholder="Write Here" required></textarea>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger">Reject</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!------------- track ---------->
<div id="modal_track_view_his" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 969px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View Ticket History</h4>
      </div>
      <form id="reject_ticket">
      <div class="modal-body" style="overflow: auto;min-height: 200px;max-height: 500px;">
        <div class="row">
            <div class="col-sm-12">
               <div class="track" id="tracker_view_his">
            </div>
            </div>
        
      </div>
      </div>
      <div class="modal-footer">
        <button style="cursor: pointer;" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      
      </form>
    </div>

  </div>
</div>




<!--start data table with export button-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table/css/dataTables.bootstrap.min.css"/> 
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table/css/buttons.bootstrap.min.css"/> 
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
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [
            {
                extend: 'excel',
                split: [ '', ''],
            }
        ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
} );
</script>
<!--end data table with export button-->

<script>
$(function() {  
 $('#multiselect').multiselect(); });
</script>

<script>
$(document).on('change','#addTicketModel #req_type',function(){
    var type=$(this).val();
    if(type == 1) {
     $("#addTicketModel #new_assets_check").attr({style: "display: block"}); 
     $("#addTicketModel #exe_assets_check").attr({style: "display: none"});  
 	}
    else { 
    	$("#addTicketModel #new_assets_check").attr({style: "display: none"});
    	$("#addTicketModel #exe_assets_check").attr({style: "display: block"}); 
    }
});
</script>

<script>
$(document).on('change','#addTicketModel .get_assets_category_data',function(){
    //var assets_id=$("#addTicketModel .assets_id").val();
	var assets_id =$("#new_asset").val();
	 var exe_assets = $("#exe_assets").val();
	//alert(exe_assets);
    var request_url = "<?php echo base_url('it_assets_support/get_assets_category_lits'); ?>";
    var datas = {'assets_id': assets_id,'exe_assets':exe_assets};
	if(assets_id=='others'){
		var option_user = '<option value="others"> Others</option>';
		$('#addTicketModel #assets_category_id').html(option_user);
	}
	else{
		process_ajax(function(response)
	{
		var res = JSON.parse(response);
		var option_user = '<option value="">--Select category---</option>';
		var option_user ='<option value="others">Others</option>';
		if (res.stat == true) {
			$.each(res.datas,function(index,element)
			{
				option_user += '<option value="'+element.id+'" >'+element.name+'</option>';
			});
			$('#addTicketModel #assets_category_id').html(option_user);
		}
		else if (res.stat == Others){

			// option_user += '<option value="">Others</option>';
			// $('#addTicketModel #assets_category_id').html(option_user);
			alert('asdsadsad');
		}
		
	},request_url, datas, 'text');

	}
	

});
</script>

<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#select_location').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); 
</script>

<script>

function cancel_ticket(ticket_id) {

	if(confirm("Are you sure?")) {
		var request_url = '<?php echo base_url('it_assets_support/cancel_ticket'); ?>',
		datas ={'ticket_id': ticket_id}
		
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			var a = res;
			//alert(a);
			if (res==true){
				alert('Ticket Cancelled Successfully');
				$("#example").load(location.href + " #example");
			}
			else{
				alert('Something went wrong')
			}
		},request_url, datas, 'text');
  }
}

function approve_reject(id) {
	alert(id);
	var hod_action =$("#hod_action").val();
	
	var request_url = '<?php echo base_url('it_assets_support/approve_reject'); ?>',
	datas ={'id':id,'hod_action':hod_action}
	
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		var a = res;
		//alert(a);
		if (res==true){
			alert (response);
			//alert('res==true');
			$("#example").load(location.href + " #example");
			
		}
		else{
			alert('Something went wrong')
		}
		
	},request_url, datas, 'text');
}

function open_modal(id,ticket_id){

	//alert(val);
	var ap_res = $('#ap_res').val();
	$("#myModal").modal('show');
	$("#result").val(id);
	$("#approval_val").val(ap_res);
	$("#ticket_id").val(ticket_id);


  }

$("#add_reason").click(function(){  
	var result =$("#result").val();
	var valid_reason =$("#valid_reason").val();
	var approval_val =$("#approval_val").val();
	var ap_res = $('#ap_res').val();
	var ticket_id = $('#ticket_id').val();

	//alert(result);
	$.ajax({
    type: "POST",
    url: "<?php echo base_url('it_assets_support/approve_reject'); ?>",
    data: {'result': result,'valid_reason':valid_reason,'ap_res':ap_res,'ticket_id':ticket_id},
    success: function(result) {
        alert(result);
        $("#example").load(location.href + " #example");
    }
})
	
   
});

</script>

<script>
$(document).on('click','.view_ticket_his',function(){
    var ticket_id = $(this).attr('id');
    var request_url = '<?php echo base_url('it_assets_support/tic_view_history'); ?>';
    var datas ={'ticket_id': ticket_id};
    process_ajax(function(response)
    {
        var res = JSON.parse(response);
        var tracker = "";
         if (res.stat==true){

            $.each(res.datas,function(index,element) {
                if (element.status_id==1) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Pending</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }
                else if (element.status_id==4) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">On Hold / In-progress</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }
                else if (element.status_id==5 && element.hod_approval == null) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">IT Action</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }
                else if (element.status_id==8 && element.hod_approval == 1) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">HOD Approved</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>';
                }
                else if (element.status_id==6 && element.hod_approval == 2) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">HOD Approved Rejected</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }           
                else if(element.status_id == 7) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Closed</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>'; 
                }
                else if(element.status_id == 2) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Rejected</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>';
                }
                else if(element.status_id == 3) {
                    tracker += '<div class="step active"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Canceled</div><div class="text">Action By: <span style="color: rgba(0,0,0,0.5);"> '+element.act_name+'</span></div><div class="text">Comments:  <span style="color: rgba(0,0,0,0.5);">'+element.comments+'</span></div><div class="date_title">'+element.date+'</div></div>';
                }

            });
            if (res.datas[0].status == 1 || res.datas[0].status == 4) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">IT Action</div> </div>  ';
            }
            else if(res.datas[0].status == 5 && res.datas[0].hod_approval == null) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">HOD Approval Pending</div></div> ';
            }

            if (res.datas[0].status == 5 && res.datas[0].hod_approval == 1 && res.datas[0].req_type == 1) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">New Assets Assign Pending</div></div> ';
            }

            if (res.datas[0].status == 5 && res.datas[0].hod_approval == 1 && res.datas[0].req_type == 2 && res.datas[0].it_action == 4) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Customization Under Process</div></div> ';
            }            

            if(res.datas[0].status != 7 && res.datas[0].status != 2 && res.datas[0].status != 3) {
                tracker += '<div class="step"><div class="icon"><i class="fa fa-check"></i></div> <div class="text">Close</div></div> ';
            }

            $('#modal_track_view_his #tracker_view_his').html(tracker);
        }
        else{alert('Something went wrong')}
    },request_url, datas, 'text');

    $('#modal_track_view_his').modal('show');
});
</script>

