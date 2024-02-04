
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
			<h4 class="widget-title">Ameridial Downtime Reports</h4>
			</header>
		</div>
		</div>
		
		
		
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body">
					<form id="form_new_user" method="POST" action="">
						
							<div class="row">
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Select Location</label>
										<select class="form-control" name="excel_office_id" id="excel_office_id" >
											<?php
											if(get_global_access()==1 || $showAll == true){
												echo "<option value='ALL'>ALL</option>";
											}
											?>
											<?php foreach($location_list as $loc): ?>
												<?php
												$officeReportsArray = array('ELS', 'SPI', 'MIN', 'MON', 'HIG', 'UTA', 'CAM', 'FTK', 'TEX');
												$sCss="";
												if($loc['abbr']==$OfficeSelected) $sCss="selected";
												if(in_array($loc['abbr'],$officeReportsArray)){
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['location']; ?></option>
												
												<?php } 
												endforeach; ?>
																					
										</select>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Select Process</label>
										<select style="width:100%" class="form-control" name="process_id" required>										
											
											<?php if(get_login_type() != "client"){ ?>
											<option value="ALL">ALL</option>
											<?php } else { ?>
											<option value="">-Select-</option>
											<?php } ?>
											<?php 
											if(!empty($process_list)){
											foreach($process_list as $process){ 
											?>
											<option value="<?php echo $process['id']; ?>"><?php echo $process['name']; ?></option>
											<?php } } ?>							
										</select>
									</div>
								</div>
								
									
								<div class="col-md-1" style="margin-top:20px">
									<div class="form-group">
										<button class="btn btn-success waves-effect excelAsset" type="submit">Download Report</button>
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