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
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-header">
						<h4 class="widget-title">
						User Request For Online Asset Submission (Existing User)
							<a class="btn btn-success btn-sm add-ticket pull-right" href="#" data-toggle="modal" data-target="#addTicketModel" title="Add Ticket" style='font-size:10px; margin-left:20px;'>Add Ticket</a>
						</h4>
						<div><?php 
						echo $this->session->flashdata('serv_msg');
						unset($_SESSION['serv_msg']);
						?></div>
					</div>
					<hr class="widget-separator">
					<div class="widget-body">						
						<div class="filter-widget">
							<!-- <div class="row">
								<form method="get" action="<?php echo base_url()?>servicerequest">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Start date</label>
											<input name="start_date" value="<?=$start_date?>" type="date" class="form-control" id="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>End date</label>
											<input name="end_date" value="<?=$end_date?>" type="date" class="form-control" id="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Location</label>
												<select name="office_id[]" id="multiselectwithsearch" class="multi_location form-control" multiple="multiple">
													<?php if($is_global_access==1){ ?>             
													<?php } ?>
													<?php foreach($location_list as $loc): ?>
														<?php
														$sCss="";
														if($loc['abbr']==$office_id) $sCss="selected";
														?>
														<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
														
													<?php endforeach; ?>
												</select>											
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Category</label>
												<select name="sr_category" id="loc_cat" class="select-box">
													<option value="ALL" <?php if($sr_category == "ALL") echo "selected"?>>ALL</option>
													<?php echo $category_dropdown ?>
												</select>											
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Priority</label>
												<select name="sr_priority" class="select-box">
													<option value="" <?php if($sr_priority == "") echo "selected" ?>>ALL</option>
													<?php foreach($priority_list as $priority): ?>
														<option value="<?php echo $priority->id ?>" <?php if($sr_priority == $priority->id) echo "selected" ?> ><?php echo $priority->priority_name; ?></option>
													<?php endforeach; ?>
												</select>											
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Status</label>
												<select name="sr_status" class="select-box">
													<option value="" <?php if($sr_status == "") echo "selected" ?>>ALL</option>
													<?php foreach($status_list as $status): ?>
														<option value="<?php echo $status->id ?>" <?php if($sr_status == $status->id) echo "selected" ?>><?php echo $status->name; ?></option>
													<?php endforeach; ?>
												</select>																			
										</div>
									</div>
									<!--<div class="col-sm-3">
										<div class="form-group">
											<label>Select Process</label>
											<select id="select-process" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>-->
									<!-- <div class="col-sm-3">
										<div class="form-group">
											<label>Select View</label>
											<select name="ticket_view" id="select-view" class="select-box">
												<option value="0" <?php if($ticket_view == "0") echo "selected"?>>Show All Tickets</option>
												<option value="1"<?php if($ticket_view == "1") echo "selected"?>>Show My Tickets</option>
											</select>								
										</div>
									</div>
									<div class="col-sm-3" style="display: none;">
										<div class="form-group">
											<label>Show Transferred</label>
												<select name="sr_transferred" class="select-box">
													<option value="0" <?php if($transferred == "0") echo "selected" ?>>Show All</option>
													<option value="1" <?php if($transferred == "1") echo "selected" ?>>Do not Show Transferred</option>
													<option value="2" <?php if($transferred == "2") echo "selected" ?>>Show Only Transferred</option>
												</select>							
										</div>
									</div>									
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" class="submit-btn">
												<i class="fa fa-search" aria-hidden="true"></i>
												Search
											</button>
										</div>
									</div>
								</form>
							</div> --> 
						</div>
					</div>
				</div>
				<!--<div class="common-top">
					<div class="widget">
						<header class="widget-header" style="padding:10px">
							<h4 class="widget-title" style="line-height:35px; display:block"> 
								Records Found : demo
								<a class="btn btn-success btn-sm add-ticket pull-right" href="#" data-toggle="modal" data-target="#addTicketModel" title="Add Ticket" style='font-size:10px; margin-left:20px;'>Add Ticket</a>
							</h4>
							<div style="margin-top:10px;"> 
								<form method="get" action="<?php echo base_url()?>servicerequest">
									<div class="table table-bordered table-responsive">
										<div style="display:table-row">
											<div style="display:table-cell;padding:0px 10px;">
												<label style="display:block">View</label>                                 
												<select name="ticket_view" style="height:28px;margin-top:2px;">
													<option value="0" <?php if($ticket_view == "0") echo "selected"?>>Show All Tickets</option>
													<option value="1"<?php if($ticket_view == "1") echo "selected"?>>Show My Tickets</option>
												</select>
											</div>
											<div style="display:table-cell;padding:0px 10px;">
												<label style="display:block">Location</label>                                 
												<select name="office_id" id="location_dt" style="height:28px;margin-top:2px;" >
													<option>--Select--</option>
													<?php if($is_global_access==1){ ?>             
													<option value="ALL">ALL</option>
													<?php } ?>
													<?php foreach($location_list as $loc): ?>
														<?php
														$sCss="";
														if($loc['abbr']==$office_id) $sCss="selected";
														?>
														<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
														
													<?php endforeach; ?>
												</select>
											</div>
											<div style="display:table-cell;padding:0px 10px;">
												<label style="display:block">Select Category/Subcategory</label>
												<select name="sr_category" id="loc_cat" style="height:28px;margin-top:2px;">
														<option value="ALL" <?php if($sr_category == "ALL") echo "selected"?>>ALL</option>
														<?php echo $category_dropdown ?>
												</select>
												<select name="sr_sub_category" id="sub_category" style="height:28px;margin-top:2px;">
													<option value="0" <?php if($sr_sub_category == "0") echo "selected"?>>ALL</option>
													<?php echo $sub_category_dropdown ?>
												</select> 
											</div>
											<div style="display:table-cell;padding:0px 10px;">
												<label style="display:block">Select Status</label>
												<select name="sr_status" style="height:28px;margin-top:2px;">
													<option value="" <?php if($sr_status == "") echo "selected" ?>>ALL</option>
													<?php foreach($status_list as $status): ?>
														<option value="<?php echo $status->id ?>" <?php if($sr_status == $status->id) echo "selected" ?>><?php echo $status->name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										
										<div style="display:table-row">	 
											
											<div style="display:table-cell;padding:5px 10px;">
												<label style="display:block">Select Priority</label>
												<select name="sr_priority" style="height:28px;margin-top:2px;">
													<option value="" <?php if($sr_priority == "") echo "selected" ?>>ALL</option>
													<?php foreach($priority_list as $priority): ?>
														<option value="<?php echo $priority->id ?>" <?php if($sr_priority == $priority->id) echo "selected" ?> ><?php echo $priority->priority_name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div style="display:table-cell;padding:5px 10px;">
												<label style="display:block">Show Transferred</label>                                 
												<select name="sr_transferred" style="height:28px;margin-top:2px;">
													<option value="0" <?php if($transferred == "0") echo "selected" ?>>Show All</option>
													<option value="1" <?php if($transferred == "1") echo "selected" ?>>Do not Show Transferred</option>
													<option value="2" <?php if($transferred == "2") echo "selected" ?>>Show Only Transferred</option>
												</select>
											</div>
											<div style="display:table-cell;padding:5px 10px;">
												<label style="display:block">Search</label>
												<input placeholder="Search BY Fusion ID" type="text" name="search" id="search" style="height:28px; width:360px; margin-top:2px;margin-left:6px;" value="<?php echo $search; ?>">
											</div>
											<div style="display:table-cell;padding:0px; margin: 25px 0px 0px 10px; position: absolute;">
												<button class="btn btn-sm btn-success">SEARCH</button>
											</div>
										</div> 
										
									</div>   
								</form>                   
							</div>
						</header>
					</div>
				</div>-->
				
			
				
            </div>
        </div>
    </section>
</div>


<!---------------Add Ticket Model-------------------->
<div class="modal fade in modal-design" id="addTicketModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <form  enctype="multipart/form-data" id="frmAddTicket" action="<?php echo base_url(); ?>servicerequest/add_ticket" data-toggle="validator" method="POST" novalidate="true">
            
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Add New Ticket</h4>
        </div>
        <div class="modal-body">
			<div class="filter-widget">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="form-check-label" for="category">Select Type <span style="color: red">*</span></label>
							<select name="s_type" class="select-box" id="s_type" required>
							<option value="" >Select</option>
							<option value="1" >New Assets</option>
							<option value="2" >Existing Assets</option>
								
							</select>                      
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label style="display:block">Location <span style="color: red">*</span></label>                                 
							<select class="select-box" name="office_id" id="location_dt1" required>
								<option value="" selected disabled>Select a Location</option>
								<?php if($is_global_access==1){ ?>             
								<!--<option value="All">ALL</option>-->
								<?php } ?>
								<?php foreach($location_list as $loc): ?>
									<?php
									$sCss="";
									if($loc['abbr']==$office_id) $sCss="selected";
									?>
									<option value="<?php echo $loc['abbr']; ?>" ><?php echo $loc['office_name']; ?></option>
									
								<?php endforeach; ?>
							</select>                      
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="form-group">
							<label class="form-check-label" for="category">Category <span style="color: red">*</span></label>
							<!--<select class="form-control" id="loc_cat1" name="category" required>
								<option value="" selected disabled>Select a Category</option>
								<?php //echo $category_dropdown_form; ?>
							</select>-->
							<select name="category" id="loc_cat1" class="select-box" required>
								<option value="" <?php if($sr_category == "ALL") echo "selected"?>>Select a Category</option>
								<?php echo $category_dropdown ?>
							</select>							                     
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="form-check-label" for="sub_category">Sub Category</label>
							<!--<select class="form-control" id="sub_category1" name="sub_category"></select>
							<?php //echo $category_dropdown ?>-->
							<select name="sub_category" id="sub_category1" class="form-control">
								<option value="" selected>Select a Sub Category</option>
								<?php 
								// foreach($sub_category_data as $key => $value)
								// {
								// 	echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
								// }
								?>
							</select>								                   
						</div>
					</div>
					<div class="col-md-3" style="display:none">
						<div class="form-group">
							<label class="form-check-label" for="due_date">Due Date</label>
							<input type="date" class="form-control" id="due_date" name="due_date">                        
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-check" style="line-height:35px">
							<input type="checkbox" class="form-check-input" id="self_submit" value="1" name="self_submit">
							<label class="form-check-label" for="exampleCheck1">Submit on behalf of another user</label>                        
						</div>
					</div>
					<div class="col-md-4" id="on_behalf_of-div"  style="display:none">
						<!--<label class="col-md-4 form-check-label" for="on_behalf_of" style="line-height:30px;text-align:right;">User's Name</label>--> 
						<!--<input type="text" class="form-control" id="on_behalf_of" name="on_behalf_of" placeholder="User's Name or Fusion ID">-->
						<select class="form-control" id="on_behalf_of" name="on_behalf_of">
							<option value="" selected disabled>--Select--</option>
							<!--<?php //foreach($user_ticket_list as $row): ?>
								<option value="<?php //echo $row['id']; ?>"><?php //echo $row['fname']." ".$row['lname']." (".$row['fusion_id'].")"; ?></option>
							<?php //endforeach; ?>-->
						</select>
					</div>
					<div class="col-md-4">
						<div class="select-widget">
							<label for="attachments" style="text-align:right;display:none;">Attach</label> 
							<input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
						</div>
					</div>
				</div>
				<div class="row" style="padding-top:5px;">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-check-label" for="subject">Subject <span style="color: red">*</span></label>
							<input pattern=".{10,100}" type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>                        
						</div>
					</div>
				</div>
				 <div class="row" style="padding-top:0px;">
					<div class="col-md-12">
						<div class="form-group textarea-widget">
							<label>Ticket Details <span style="color: red">*</span></label>
							<textarea style="width: 100%;height: auto;padding: 10px;height: 100px;transition: all 0.5s ease-in-out 0s;border: 1px solid #ddd;resize: none;" id="details_ticket" name="details" required></textarea>
						</div>
					</div>
				</div>
			</div>			
        </div>
        
        <div class="modal-footer">
            <button type="button" id="addTicket" class="submit-btn">Submit</button>
            <button type="button" class="pop-danger-btn" data-dismiss="modal">Cancel</button>
        </div>
        
        </form>
        
        </div>
    </div>
</div>

<!-----------------Assign Ticket Model---------------------->
<div class="modal fade modal-design" id="edit_pop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="filter-widget pop-dropdown">
			<div class="row">
			<form action="<?php echo base_url(); ?>servicerequest/assign_tickets" method="post">					
				<div class="col-sm-4">
					<div class="form-group">
						<label>Location</label>
						<select id="multi_location_pop" class="select-box" name="assign_loc" required>
							<option value="">Select Location</option>
							<?php foreach($location_list as $loc): ?>
									<?php
									$sCss="";
									if($loc['abbr']==$office_id) $sCss="selected";
									?>
									<option value="<?php echo $loc['abbr']; ?>" ><?php echo $loc['office_name']; ?></option>
									
								<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label>Select Department</label>
						<select name="department_name" id="department-pop" class="select-box department_name" required>
							<option value="">Select Department Name</option>
								<?php
								foreach($department_data as $value) {
									echo '<option value="'.$value['id'].'">'.$value['shname'].'</option>';
								}
								?>
						</select>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label>Assign Ticket</label>
						<select id="department-pop2" class="form-control user_names" name="user_name" required>
							<option value="">Select User Name</option>
						</select>
					</div>
					<input type="hidden" id="ticket_id" value="" name="ticket_id">
				</div>
			</div>
			<div class="pop-btn-widget">
				<button type="submit" class="submit-btn">Submit</button>
			</div>
		</form>
		</div>
      </div>      
    </div>
  </div>
</div>

<!-----------------View Ticket Model---------------------->
<div class="modal fade modal-design" id="ticket_view_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="filter-widget pop-dropdown">
			<form action="<?php echo base_url(); ?>servicerequest/ticket_status_update" method="post">					
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<p><strong>Reference ID:</strong> <span id="tic_reference"></span></p>
							<p><strong>Subject:</strong> <span id="tic_subject"></span></p>
							<p><strong>Ticket Details:</strong> <span id="tic_details"></span></p>
							<p id="behalf_of"></p>
							<p id="files"></p>			
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<br>
							<label>Update Status</label>
							<select name="status_update" class="select-box" required >
									<?php foreach($status_list as $status): ?>
								<option value="<?php echo $status->id ?>" <?php if($sr_status == $status->id) echo "selected" ?>><?php echo $status->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<input type="hidden" name="ticket_id" id="input_tic_id" value="" required >
						<input type="hidden" name="assign_to" id="assign_to_input" value="" required >
					</div>
					<br>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Comments</label>
							<textarea style="width: 100%;height: auto;padding: 10px;height: 100px;transition: all 0.5s ease-in-out 0s;border: 1px solid #ddd;resize: none;" placeholder="Write Here" name="comments"></textarea>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="pop-btn-widget">
							<button type="submit" class="submit-btn">Submit</button>
						</div>
					</div>
				</div>
			</form>	
		</div>
      </div>      
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

<script>
	$("#s_type").change(function(){
		var tp = $("#s_type").val()
		//alert(tp);
		if(tp=='1'){
		
			alert('new type');

		}
		else {
		
			alert('type');
		}
		
	});
	</script>
<!--end data table with export button-->