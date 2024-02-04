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
						<h4 class="widget-title">All Candidate List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
							
					<div class="widget-body">
					
						<?php echo form_open('',array('method' => 'get')) ?>
						
							<input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>' >
							
							<div class="filter-widget">								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Start Date</label>
											<input type="text" class="form-control" id="from_date" name="from_date" value="<?php echo $from_date;?>" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>End Date</label>
											<input type="text" class="form-control" id="to_date" name="to_date" value="<?php echo $to_date;?>" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Brand</label>
											<select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>
												
												<?php foreach ($company_list as $key => $value) { 
												$bss="";
												if(in_array($value['id'],$brand))$bss="selected";	
												?>	
														<option value="<?php echo $value['id']; ?>"<?php echo $bss;?>><?php echo $value['name']; ?></option>
												<?php  }?> 
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Location</label>
											<select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>
												
												<?php
												//if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
											?>
											<?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if(in_array($loc['abbr'],$oValue)) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Department</label>
											<select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
											<?php
												foreach($department_list as $k=>$dep){
												$sCss="";
												if(in_array($dep['id'],$o_department_id))$sCss="selected";	
											?>
											<option value="<?php echo $dep['id']; ?>"<?php echo $sCss;?>><?php echo $dep['shname']; ?></option>
											<?php		
												}
											?>	
											</select>
										</div>
									</div>									
									
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Client</label>
											<select id="fclient_id" name="client_id[]" autocomplete="off" placeholder="Select Client" multiple>	
											<?php foreach($client_list as $client): 
												$cScc='';
												if(in_array($client->id,$client_id)) $cScc='Selected';
											?>
											<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?> ><?php echo $client->shname; ?></option>
											<?php endforeach; ?>	
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Select Process</label>
											<select id="fprocess_id"  name="process_id" autocomplete="off" placeholder="Select Process" class="select-box" >
											<option value="">-- Select Process--</option>	
											<?php foreach($process_list as $process): 
												$cScc='';
												if($process->id==$process_id) $cScc='Selected';
											?>
											<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?> ><?php echo $process->name; ?></option>
											<?php endforeach; ?>	
											</select>
										</div>
									</div>
									<div class="col-sm-3" id="requisation_div" style="display:none;">
										<div class="form-group">
											<label>Requisition</label>
											<select  autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="Select Requisition" class="select-box">
											<option="">ALL</option>	
											<?php /*foreach($get_requisition as $gr): ?>
											<?php
												$sRss="";
												if($gr['requisition_id']==$requisition_id) $sRss="selected";
											?>
												<option value="<?php echo $gr['requisition_id']; ?>" <?php echo $sRss; ?>><?php echo $gr['requisition_id']; ?></option>
											<?php endforeach;*/ ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="search" id="search" value="Search" class="submit-btn">
												<i class="fa fa-search" aria-hidden="true"></i>
												Search
											</button>
										</div>
									</div>
								</div>
								
							</div>
							
						</form>							
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
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requision Code</th>
										<th><b>Candidate Name</b></th>
										<th>Hiring Source</th>
										<th>Onboarding Type</th>
										<th>Gender</th>
										<th>Mobile</th>
										<th>DOB</th>
										<th>State</th>
										<th>City</th>
										<th>Postcode</th>
										<th>Country</th>
										<th><b>Status</b></th>
										<th>Added Date/Time</th>
									</tr>
								</thead>
								<tbody id="myTable">
									<?php $i=1;
										foreach($list_candidates as $row): 
										
										$rid=$row['rid']; //echo $rid;
										
										if($row['candidate_status']=='P'){
											$status="Pending";
										}else if($row['candidate_status']=='IP'){
											$status="In Progress";
										}else if($row['candidate_status']=='SL'){
											$status="Shortlisted";
										}else if($row['candidate_status']=='CS'){
											$status="Candidate Selected";
										}else if($row['candidate_status']=='E'){
											$status="Candidate Select as Employee";
										}else if($row['candidate_status']=='D'){
											$status="Dropped Candidate";
										}else{
											$status="Rejected";
										}
										
										if($row['requisition_status']=='CL'){
											$fcolor="style='color:red'";
										}else{
											$fcolor="";
										}
										?>
									<tr>
										<td><?php echo $i++; ?></td>
										
										<td style='font-weight:bold'><a href="<?php echo base_url(); ?>dfr/view_requisition/<?php echo $rid; ?>" target="_blank" <?=$fcolor;?> ><?php echo $row['req_id']; ?></a></td>
										
										<td><b><?php echo $row['fname']." ".$row['lname']; ?></b></td>
										<td><?php echo $row['hiring_source']; ?></td>
										<td><?php echo $row['onboarding_type']; ?></td>
										<td><?php echo $row['gender']; ?></td>
										<td><?php echo $row['phone']; ?></td>
										<td><?php echo $row['d_o_b']; ?></td>
										<td><?php echo $row['state']; ?></td>
										<td><?php echo $row['city']; ?></td>
										<td><?php echo $row['postcode']; ?></td>
										<td><?php echo $row['country']; ?></td>
										<td><b><?php echo $status; ?></b></td>
										<td><?php echo $row['added_date']; ?></td>
									</tr>
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

<script type="text/javascript">
	document.querySelector("#req_no_position").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
});
</script>
<script>
/*$(function() {  
 $('#multiselect').multiselect();

 $('#edurequisition_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#fdoffice_ids').multiselect({
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

 $('#select-brand').multiselect({
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

 $('#fclient_id').multiselect({
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

 $('#fprocess_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('#select-department').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});

</script>
<script>
	 $(document).ready(function () {
      $('.select-box').selectize({
          sortField: 'text'
      });
  });
  
</script>
