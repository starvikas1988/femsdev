<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	.btn{
		/*min-width:105px;*/
	}
	.label {
		/*padding: .7em .6em;*/
	}
	#req_qualification_container
	{
		display:none;
	}
</style>

<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					
					<div class="row">
						<div class="col-md-4">
							<header class="widget-header">
								
								<h4 class="widget-title">Master Mis</h4>
							</header>
						</div>
						
					</div>
					<hr class="widget-separator">
					
					<div class="widget-body">
					
						<form id="form_new_user" method="POST" action="<?php echo base_url(); ?>dfr/master_mis_download">
						<?php //echo form_open('',array('method' => 'get')) ?>
						
							<input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>' >
							
							<!--<div class="filter-widget">
								<div class="row">
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
							
							<!--start old backup php code-->
							<div class="row" style="display:none1;">
							
								<div class="col-md-2">
									<div class="form-group">
										<label>Location</label>
										<select class="form-control" name="office_id" id="fdoffice_id" >
											<?php
												/*if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";*/
											?>
											<?php foreach($location_data as $loc): ?>
												<?php
												$sCss="";
												if($loc['abbr']==$oValue) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
																					
										</select>
									</div>
								</div>

								<!--<div class="col-md-3">
									<div class="form-group">
										<label>From Date</label>
										<input type="text" name="from_date" id="from_date" class="form-control">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>To Date</label>
										<input type="text" name="to_date" id="to_date" class="form-control">
									</div>
								</div>---->
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Select Client</label>
										<select class="form-control" id="fclient_id" name="client_id" >
											<option value='ALL'>ALL</option>
											<?php foreach($client_list as $client): 
												$cScc='';
												if($client->id==$client_id) $cScc='Selected';
											?>
											<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?> ><?php echo $client->shname; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Select Process</label>
										<select class="form-control" id="fprocess_id" name="process_id" >
											<option value="">--Select--</option>
											<?php foreach($process_list as $process): 
												$cScc='';
												if($process->id==$process_id) $cScc='Selected';
											?>
											<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?> ><?php echo $process->name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
									
								<div class="col-md-1" style="margin-top:25px">
									<div class="form-group">
										<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>dfr/master_mis_download" type="submit" id='btnView' name='btnView' value="View">View</button>
									</div>
								</div>
							</div>
							<!--end old backup php code-->
							
							
						</form>
						
					</div>
				</div>
			</div>
		</div>
		

	</section>
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