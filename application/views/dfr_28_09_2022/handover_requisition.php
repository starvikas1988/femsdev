<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
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
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Handover Requisition List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
							
					<div class="widget-body">
						<div class="filter-widget">
								<!--<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Start date</label>
											<input type="date" class="form-control" id="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>End date</label>
											<input type="date" class="form-control" id="">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Location</label>
											<select id="multiselectwithsearch" multiple="multiple">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Requisition</label>
											<select id="multiselectwithsearch" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Brand</label>
											<select id="brand" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Client</label>
											<select id="select-client" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
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
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Department</label>
											<select id="select-department" class="select-box">
												<option value="India">India</option>
												<option value="Australia">Australia</option>
												<option value="United State">United State</option>
												<option value="Canada">Canada</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Romania">Romania</option>
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
								</div>
							</div>-->
						
						<?php if(get_global_access()==1){ ?>
							<form id="form_new_user" method="GET" action="<?php echo base_url('dfr/handover_dfr_requisition'); ?>">
								<!--start old backup php code-->
								<div class="row" style="display:none1;">
									<div class="col-md-3">
										<div class="form-group">
											<label for="office_id">Select a Location</label>
											<select class="form-control" name="off_id" id="officeLocation" >
												<option value=''>Select</option>
												<option value='All'>ALL</option>
												<?php foreach($location_list as $loc): 
													$sCss="";
													if($loc['abbr']==$off_id) $sCss="selected";
													?>
												<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-1" style="margin-top:20px">
										<div class="form-group">
											<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>dfr/handover_dfr_requisition" type="submit" id='btnView' name='btnView' value="View">View</button>
										</div>
									</div>
								
								</form>
							</div>
							<!--end old backup php code-->
						<?php } ?>
						
						
					</div>
			
			
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
		
		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="widget">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requision Code</th>
										<th>Location</th>
										<th>Department</th>
										<th>Due Date</th>
										<th>Position</th>
										<th>Client</th>
										<th>Process</th>
										<th>Batch No</th>
										<th>Required Position</th>
										<th>Filled Position</th>
										<th>Raised By</th>
										<th>Assign Supervisor</th>
										<th>Assign Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=1;
										foreach($handover_requisition_list as $row):
										$rid=$row['id'];
										$handoverDate=$row['assign_tl_date'];
										$handoverName=$row['l1_sup_name'];
										$handoverid=$row['l1_supervisor'];
										$raised_by=$row['raised_by'];
										$dept_id=$row['department_id'];
										$role_folder=$row['role_folder'];
										$off_location=$row['off_loc'];
										
										if($row['count_canasempl'] > 0){	
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['requisition_id']; ?></td>
										<td><?php echo $row['off_loc']; ?></td>
										<td><?php echo $row['department_name']; ?></td>
										<td><?php echo $row['dueDate']; ?></td>
										<td><?php echo $row['role_name']; ?></td>
										<td><?php echo $row['client_name']; ?></td>
										<td><?php echo $row['process_name']; ?></td>
										<td><?php echo $row['job_title']; ?></td>
										<td><?php echo $row['req_no_position']; ?></td>
										<td><?php echo $row['count_canasempl']; ?></td>
										<td><?php echo $row['raised_name']; ?></td>
										<td><?php echo $row['l1_sup_name']; ?></td>
										<td><?php echo $row['assign_tl_date']; ?></td>
										<td style="text-align:center;width:80px;">
										<?php 
										if($dept_id=='6' && $role_folder=='agent'){
											if($row['location']!='CHA'){
											echo "<button title='Handover Requisition' type='button' rid='$rid' handoverDate='$handoverDate' handoverName='$handoverName' handoverid='$handoverid' raised_by='$raised_by' dept_id='$dept_id' role_folder='$role_folder' class='btn btn-success btn-xs closedRequisition' style='font-size:12px'><i class='fa fa-street-view' aria-hidden='true'></i></button>";
											echo'&nbsp;&nbsp;';
										  }else{
										  	//if($handoverid==''){
										  		echo "<button title='Handover Requisition' type='button' rid='$rid' handoverDate='$handoverDate' handoverName='$handoverName' handoverid='$handoverid' raised_by='$raised_by' dept_id='$dept_id' role_folder='$role_folder' class='btn btn-success btn-xs closedRequisitionhnd' style='font-size:12px'><i class='fa fa-street-view' aria-hidden='true'></i></button>";
											echo'&nbsp;&nbsp;';
											//}else{
											echo"<button title='Closed Requisition' type='button' r_id='$rid' handoverid='$handoverid' raised_by='$raised_by' dept_id='$dept_id' role_folder='$role_folder' handoverName='$handoverName' class='btn btn-danger btn-xs closeRequisitionfinal'  style='font-size:12px'><i class='fa fa-times-circle' aria-hidden='true'></i></button>";
											//}
										}
											
										}else{
											if($row['location']!='CHA'){
											echo "<button title='Handover Requisition' type='button' rid='$rid' handoverLocation='$off_location' handoverDate='$handoverDate' handoverName='$handoverName' handoverid='$handoverid' raised_by='$raised_by' dept_id='$dept_id' role_folder='$role_folder' class='btn btn-success btn-xs closedRequisition1' style='font-size:12px'><i class='fa fa-street-view' aria-hidden='true'></i></button>";
											echo'&nbsp;&nbsp;';
										  }else{
										  	//if($handoverid==''){
										  		echo "<button title='Handover Requisition' type='button' rid='$rid' handoverLocation='$off_location' handoverDate='$handoverDate' handoverName='$handoverName' handoverid='$handoverid' raised_by='$raised_by' dept_id='$dept_id' role_folder='$role_folder' class='btn btn-success btn-xs closedRequisitionhnd1' style='font-size:12px'><i class='fa fa-street-view' aria-hidden='true'></i></button>";
											echo'&nbsp;&nbsp;';
										  	//}else{
											echo"<button title='Closed Requisition' type='button' r_id='$rid'handoverid='$handoverid' raised_by='$raised_by' dept_id='$dept_id' role_folder='$role_folder' handoverName='$handoverName' class='btn btn-danger btn-xs closeRequisitionfinal'  style='font-size:12px'><i class='fa fa-times-circle' aria-hidden='true'></i></button>";
											//}
											
										}
										}									
										?>
										</td>
									</tr>
									
									<?php } ?>
									
									<?php endforeach; ?>
								</tbody>
								
							</table>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>
	
</div><!-- .wrap -->

<!----------------------------------------------------------------->

<!-------------------- closed Requisition model ----------------------------->
<div class="modal fade" id="closedRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmclosedRequisition closedhandover-req-all-loc" action="<?php echo base_url(); ?>dfr/handover_closed_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> Handover And Close Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="rid" name="rid" >
			<input type="hidden" id="handoverid" name="handoverid" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			<input type="hidden" id="raised_by" name="raised_by" >
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Assign TL</label>
						<input type="text" readonly id="handoverName" name="handoverName" class="form-control">
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Phase Type</label>
						<select id="" name="phase_type" class="form-control">
							<option value="2">Training</option>
						</select>
					</div>	
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
						<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='closedRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<div class="modal fade" id="closedRequisitionModel1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmclosedRequisition1 closedhandover-req-all-loc" action="<?php echo base_url(); ?>dfr/handover_closed_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Handover And Close Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="rid" name="rid" >
			<input type="hidden" id="handoverid" name="handoverid" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			<input type="hidden" id="raised_by" name="raised_by" >
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Assign TL</label>
						<input type="text" readonly id="handoverName" name="handoverName" class="form-control">
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Phase Type</label>
						<select id="" name="phase_type" class="form-control">
							<option value="4">Production</option>
							<option value="2">Training</option>
						</select>
					</div>	
				</div>
			</div>
			<div class="site_cspl" style="display: none">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Site</label>
							<select name="site" class="form-control site" >
								<?php foreach($site_list as $site): ?>
								<option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>					
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
						<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='closedRequisition1' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<!---------------------close  edited by souvik---------------------------->
<!-------------------- closed Requisition model ----------------------------->
<div class="modal fade" id="closedRequisitionModelhd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmclosedRequisition closedhandover-req-all-loc" action="<?php echo base_url(); ?>dfr/handover_closed_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> Handover Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="rid" name="rid" >
			<input type="hidden" id="handoverid" name="handoverid" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			<input type="hidden" id="raised_by" name="raised_by" >
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Assign TL</label>
						<input type="text" readonly id="handoverName" name="handoverName" class="form-control">
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Phase Type</label>
						<select id="" name="phase_type" class="form-control">
							<option value="2">Training</option>
						</select>
					</div>	
				</div>
			</div>
			
			<!--<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
						<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
					</div>	
				</div>
			</div>-->
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='closedRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<div class="modal fade" id="closedRequisitionModelhd1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmclosedRequisition1 closedhandover-req-cha-loc" action="<?php echo base_url(); ?>dfr/handover_closed_requisition_cha" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Handover Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="rid" name="rid" >
			<input type="hidden" id="handoverid" name="handoverid" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			<input type="hidden" id="raised_by" name="raised_by" >
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Assign TL</label>
						<input type="text" readonly id="handoverName" name="handoverName" class="form-control">
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Phase Type</label>
						<select id="" name="phase_type" class="form-control">
							<option value="4">Production</option>
							<option value="2">Training</option>
						</select>
					</div>	
				</div>
			</div>
			<div class="site_cspl" style="display: none">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Site</label>
							<select name="site" class="form-control site" >
								<?php foreach($site_list as $site): ?>
								<option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>					
				</div>
			</div>
			
			<!--<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
						<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
					</div>	
				</div>
			</div>-->
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='closedRequisition1' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>



<div class="modal fade" id="closeRequisitionfinalModel1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmclosed" action="<?php echo base_url(); ?>dfr/close_requisetion_off" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Close Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="rid" name="rid" >
			<input type="hidden" id="handoverid" name="handoverid" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			<input type="hidden" id="raised_by" name="raised_by" >
			
			<div class="row">
				<div class="col-md-06">
					<div class="form-group">
						<label>Assign TL</label>
						<input type="text" readonly id="handoverName" name="handoverName" class="form-control">
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Phase Type</label>
						<select id="" name="phase_type" class="form-control">
							<option value="4">Production</option>
							<option value="2">Training</option>
						</select>
					</div>	
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
						<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='closedRequisition1' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>

<script>
	 $(document).ready(function () {
      $('.select-box').selectize({
          sortField: 'text'
      });
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

<script>
$('.closedhandover-req-all-loc').submit(function (e) {
	e.preventDefault();
	var datas = $(this).serialize();
	var request_url = "<?php echo base_url('dfr/handover_closed_requisition'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) {location.reload();}
		else alert("Something is wrong!");
	},request_url, datas, 'text');
});

//CHA Location
$('.closedhandover-req-cha-loc').submit(function (e) {
	e.preventDefault();
	var datas = $(this).serialize();
	var request_url = "<?php echo base_url('dfr/handover_closed_requisition_cha'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) {location.reload();}
		else alert("Something is wrong!");
	},request_url, datas, 'text');
});	
</script>