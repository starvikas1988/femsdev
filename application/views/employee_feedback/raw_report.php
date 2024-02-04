<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom-femsdev.css"/>
<style>
		.filter-widget .multiselect-container{
		width: 100%!important;
	}
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Generate Raw Report</h4>
					</header>
					
					<hr class="widget-separator">
					<div class="widget-body clearfix">
						<form action="<?php echo base_url('employee_feedback/gen_rawreport') ?>" method="POST" id="search_report">
						
						<div class="row filter-widget">
						<div class="col-md-4">
						<div class="form-group">
						<label>Select Location</label>
						<select class="form-control" name="office_id[]" id="office_id"   multiple="multiple"  required >
							<?php foreach($location_list as $loc):
								$sel = "";
								if($useroffice == $loc['abbr'] ) $sel="selected";
							?>
							<option value="<?php echo $loc['abbr']; ?>" <?php echo $sel;?> ><?php echo $loc['office_name']; ?></option>
							<?php endforeach; ?>			
						</select>
						</div>
						</div>
						
						<div class="col-md-4">
						<div class="form-group">
						<label>Select Quater date</label>
						<select class="form-control" name="quartertime" id="quartertime" required>
							<?php foreach($quarter_list as $tokenq):
								$sel="";
								if($cquarter == $tokenq['yearlist']) $sel="selected";
							?>
							<option value="<?php echo $tokenq['yearlist']; ?>" <?php echo $sel;?> ><?php echo $tokenq['yearlist']; ?></option>
							<?php endforeach; ?>			
						</select>
						</div>
						</div>

						<div class="col-md-4">
									<div class="form-group">
										<label>Select Department</label>
										<select class="form-control" name="report_dept_id[]" id="report_dept_id" multiple="multiple" required >
											<?php 
											// echo "<option value='ALL'>ALL</option>";
											//if(get_global_access()==1){ echo "<option value='ALL'>ALL</option>"; } 
											?>
											<?php 
											foreach($department_list as $loc): 
												$sCss=""; if($loc['id'] == $deptSelected) $sCss="selected";
											?>
											<option value="<?php echo $loc['id']; ?>" <?php echo $sCss;?>><?php echo $loc['shname']; ?></option>
											<?php endforeach; ?>				
										</select>
									</div>
								</div>
						
						<!--<div class="col-md-4">
						<select class="form-control" name="reportype" id="reportype" required>
							<option value="all">All Feedback</option>			
							<option value="pending">Pending Feedback</option>			
						</select>
						</div>-->
						
						</div>
							<div class="row no-margin">
								<div class="col-md-2">
									<button type="submit" class="btn btn-success btn-sm btn-block">Get Report</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script >
	$(function() {  
 $('#multiselect').multiselect();

 $('#report_dept_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});

</script>

<script >
	$(function() {  
 $('#multiselect').multiselect();

 $('#office_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});

</script>