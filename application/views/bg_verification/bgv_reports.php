
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	
	#show{
		margin-top:5px;
	}
	
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
	
	.modal-dialog{
		width:800px;
	}
</style>


<div class="wrap">
	<section class="app-content">
	
		<div class="row">
		
		<div class="col-md-12">
		<div class="widget">
			<header class="widget-header">
			<h4 class="widget-title">Background Verification Report</h4>
			</header>
		</div>
		</div>
		
		
		
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body">
					<form id="form_new_user" method="GET" action="">
						
							<div class="row">
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Select Location</label>
										<select class="form-control" name="report_office_id" id="report_office_id" >
											<?php
											if(get_global_access()==1){
												//echo "<option value='ALL'>ALL</option>";
											}
											?>
											<?php 
											foreach($location_list as $loc): 
											$sCss="";
											if(isIndiaLocation($loc['abbr'])){
											if($loc['abbr']==$officeSelected) $sCss="selected";
											?>
												<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['location']; ?></option>
											<?php } endforeach; ?>
																					
										</select>
									</div>
								</div>
								
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Select Department</label>
										<select class="form-control" name="report_dept_id" id="report_dept_id" >
											<?php
											if(get_global_access()==1){
												echo "<option value='ALL'>ALL</option>";
											}
											?>
											<?php 
											foreach($department_list as $loc): 
												$sCss="";
												if($loc['id']==$deptSelected) $sCss="selected";
											?>
											<option value="<?php echo $loc['id']; ?>" <?php echo $sCss;?>><?php echo $loc['shname']; ?></option>
											<?php endforeach; ?>				
										</select>
									</div>
								</div>
									
								<div class="col-md-2" style="margin-top:25px">
									<div class="form-group">
										<button type="submit" class="btn btn-success waves-effect downloadReport" name="report_download" type="submit">Download Report</button>
									</div>
								</div>
							</div>
							
					</form>	
					</div>
				</div>
			</div>
		</div>
	
	</section>
</div>