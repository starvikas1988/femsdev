
 <style>

	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:4px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.inputTable > tr > td{
		font-size:12px;
		padding:4px;
	}
	
	.hide{
	  disply:none;	  
	}
	
	.modal-dialog {
		width: 900px;
	}
	
</style>



<!-- Metrix -->

<div class="wrap">
<section class="app-content">
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Design Performance Metrix Screen</h4>
</header>
<hr class="widget-separator"/>

<div style='float:right; margin-top:-42px; margin-right:10px;' class="col-md-4">
	<div class="form-group" style='float:right;'>
	<span style="cursor:pointer;padding:5px;" id='btn_add_design' class="btn btn-primary">Create New Design</span>
	</div>
</div>
						
<div class="widget-body clearfix">

<div class="row">
	
	<?php echo form_open('',array('method' => 'get')) ?>
	
		
		<div class="col-md-2" >
			
			<div class="form-group" id="foffice_div">
				<label for="office_id">Select a Location</label>
				<select class="form-control" name="office_id" id="foffice_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($location_list as $loc): ?>
						<?php
						$sCss="";
						if($loc['abbr']==$oValue) $sCss="selected";
						?>
					<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
						
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
				<label for="client_id">Select a Client</label>
				<select class="form-control" name="client_id" id="fclient_id" >
				
					<?php foreach($client_list as $client): ?>
						<?php
						$sCss="";
						if($client['id']==$cValue) $sCss="selected";
						?>
						<option value="<?php echo $client['id']; ?>" <?php echo $sCss;?>><?php echo $client['shname']; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
		</div>
	
		<div class="col-md-2" id="process_div" >
			<div class="form-group">
			<label for="process_id">Select a process</label>
			<select class="form-control" name="process_id" id="fprocess_id" >
				<option value='0'>ALL Process</option>
				<?php foreach($process_list as $process): ?>
					<?php
						if($process->id ==0 ) continue;
						$sCss="";
						if($process->id==$pValue) $sCss="selected";
					?>
					<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
					
				<?php endforeach; ?>
				
			</select>
			</div>
		</div>
		
		<div class="col-md-2">
		<div class="form-group">
			<input type="submit" class="btn btn-primary btn-md" style="margin-top:24px;" id='showReports' name='showReports' value="Show">
			</div>
		</div>
		</form>
		
</div><!-- .row -->

</div>
</div>
</div>
</div><!-- .row -->

		<?php 
						
		foreach($pm_design as $pmrow){
			$params = $pmrow['mp_id']."#".$pmrow['office_id']."#".$pmrow['client_id']."#".$pmrow['process_id']."#".$pmrow['mp_type']."#".$pmrow['description'];
		?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Performance Metrix Screen</h4>
					</header>
					<hr class="widget-separator"/>						
					<div style='float:right; margin-top:-35px;' class="col-md-4">
						<div class="form-group" style='float:right; padding-right:10px;'>
								<button type='button' params="<?php echo $params; ?>" class='editPMButton btn btn-success btn-sm'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>
						</div>
					</div>
					
					<div class="widget-body clearfix">
						<div class="row">
							
							<div class="col-md-1">
								<label class='bold'>Location:</label>
							</div>
							<div class="col-md-2">
								<?php echo $pmrow['office_id']; ?>
							</div>
														
							<div class="col-md-1">
								<label class='bold'>Client:</label>		
							</div>
							<div class="col-md-2">
								<?php echo $pmrow['client_name'];?>
							</div>
							<div class="col-md-1">
								<label class='bold'>Process:</label>
							</div>
							<div class="col-md-2">
								<?php echo trim($pmrow['process_name']);?>
							</div>
							<div class="col-md-1">
								<label class='bold'>Type:</label>
							</div>
							
							<div class="col-md-2">
								<?php

									if($pmrow['mp_type'] == "1" ) echo "Daily";
									else if($pmrow['mp_type'] == "2" ) echo "Weekly";
									else if($pmrow['mp_type'] == "3" ) echo "Monthly";
									
								?>
							</div>
							
						</div>
						
					<?php
						$cnt=1;
						
						//echo "<pre>";
						//print_r($pm_designkpi);
						//echo "</pre>";
						
						$pmkpidtl=$pm_designkpi[$pmrow['mp_id']];
						
						foreach($pmkpidtl as $kpi){
							
							echo "<div class='row'>";
							echo "<div class='col-md-2'> <label class='bold'>KPI".$cnt++."</label></div>";
							echo "<div class='col-md-2'> <label >".$kpi['kpi_name']. ", (". $kpi['mp_type_name']. ")</label></div>";
							echo "</div>";
						}

						?>
						
						</div>
					</div>
				</div>
			</div>	
			
			<?php 
			
				}
			?>
			
		</div>
		
</section>



<!-- Start Add -->
<div class="modal fade" id="modalAddDesign" tabindex="-1" role="dialog" aria-labelledby="addAddDesign" aria-hidden="true">
  <div class="modal-dialog">
  
  
    <div class="modal-content">
		
		<form class="frmAddDesign" action="<?php echo base_url(); ?>pmetrix/addDesign" data-toggle="validator" method='POST'>
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="addDesignLabel">Add Metrix Screen</h4>
			</div>
			
			<div class="modal-body">
				
				<div class="row">
				
					<div class="col-md-6">
					
					<div class="form-group">
						<label for="office_id">Select The Location</label>
						<select class="form-control" name="office_id" id="aoffice_id" required >
							<option value=''>--Select--</option>
							<option value='ALL'>ALL</option>
							<?php foreach($location_list as $loc): ?>
								<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					
					</div>
					
					<div class="col-md-6">
					<div class="form-group">
						<label for="client_id">Select a Client</label>
						<select class="form-control" name="client_id" id="aclient_id" >
						
							<?php foreach($client_list as $client): ?>
								<?php
								$sCss="";
								if($client['id']==$cValue) $sCss="selected";
								?>
								<option value="<?php echo $client['id']; ?>" <?php echo $sCss;?> ><?php echo $client['shname']; ?></option>
								
							<?php endforeach; ?>
																	
						</select>
					</div>
					</div>
					
				</div>
				
				<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<label for="process_id">Select a process</label>
						<select class="form-control" name="process_id" id="aprocess_id" >
							<option value='0'>ALL</option>
							<?php foreach($process_list as $process): ?>
								<?php
									$sCss="";
									if($process->id==$pValue) $sCss="selected";
								?>
								<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
								
							<?php endforeach; ?>
							
						</select>
					</div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
						<label for="phone">Matrix Type:</label>
						
						<select class="form-control" name="mp_type" id="amp_type" >
							<option value='1'>Daily</option>
							<option value='2'>Weekly</option>
							<option value='3'>Monthly</option>
						</select>
						
					</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
					<div class="form-group">
						<label for="process_id">Metrix Design Title</label>
						<input type="text" class="form-control" placeholder="Design Title" name="description" id="adescription">
					</div>
					</div>
				</div>
				
				<div class="row " id='kpi_divs'>
				
					<div class="col-md-12">
						<div class="col-md-3">
							<label for="KPI_Name"> KPI Name</label>
						</div>
						<div class="col-md-2">
							<label for="summ_type"> KPI Type</label>
						</div>
						<div class="col-md-2">
							<label for="summ_type"> Summary Type</label>
						</div>
						<div class="col-md-3">
							<label for="summ_formula">Type Formula</label>
						</div>
						<div class="col-md-2">
							<label for="Action"> Action</label>
						</div>
					</div>
					
					<div class="col-md-12 kpi_input_row">
					
						<div class="col-md-3">
								<input type="text" class="form-control" placeholder="KPI Name" name="kpi_name[]">
						</div>
						
						<div class="col-md-2">
														
								<select class="form-control" name="kpi_type[]" >
								
								<?php foreach($kpi_type_list as $kpimas): ?>
									<option value="<?php echo $kpimas['id']; ?>" <?php echo $sCss;?> ><?php echo $kpimas['name']; ?></option>
								<?php endforeach; ?>
								
								</select>
						</div>
						
						<div class="col-md-2">
														
								<select class="form-control" name="summ_type[]" >
								
								<?php foreach($kpi_summtype_list as $kpimas): ?>
									<option value="<?php echo $kpimas['id']; ?>" <?php echo $sCss;?> ><?php echo $kpimas['name']; ?></option>
								<?php endforeach; ?>
								
								</select>
						</div>
						<div class="col-md-3">
								
								<input type="text" class="form-control" placeholder="Formula" name="summ_formula[]">
								
						</div>
						
						
						<div class="col-md-2">
							
								<button type="button" style="margin-top:1px;" class="btn btn-primary btnMore">More</button>
								<button type="button" style="margin-top:1px;" class="btn btn-danger btnRemove hide ">Remove</button>
								
							
						</div>
						
					</div>

			</div>
									
		</div>
		
		  <div class="modal-footer">
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" id='btnAddDesign' class="btn btn-primary">Save</button>
			
		  </div>
		  
	</form>
		
	</div>
</div>
</div>
<!-- end Add -->



<!-- Start Add -->
<div class="modal fade" id="modalUpdateDesign" tabindex="-1" role="dialog" aria-labelledby="updateDesign" aria-hidden="true">
  <div class="modal-dialog">
  
  
    <div class="modal-content">
		
		<form class="frmUpdateDesign" action="<?php echo base_url(); ?>pmetrix/updateDesign" data-toggle="validator" method='POST'>
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="updateDesignLabel">Update Metrix Screen</h4>
			</div>
			
			<div class="modal-body">
				
				<input type="hidden" id='mdid' name='mdid'>
				
				<div class="col-md-12">
				
					<div class="col-md-6">
					
					<div class="form-group">
						<label for="office_id">Select The Location</label>
						<select class="form-control" name="office_id" id="uoffice_id" required >
							<option value='ALL'>ALL</option>
							<?php foreach($location_list as $loc): ?>
								<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					
					</div>
					
					<div class="col-md-6">
					<div class="form-group">
						<label for="client_id">Select a Client</label>
						<select class="form-control" name="client_id" id="uclient_id" >
						
							<?php foreach($client_list as $client): ?>
								<option value="<?php echo $client['id']; ?>"><?php echo $client['shname']; ?></option>
							<?php endforeach; ?>
																	
						</select>
					</div>
					</div>
					
				</div>
				
				<div class="col-md-12">
					<div class="col-md-6">
					<div class="form-group">
						<label for="process_id">Select a process</label>
						<select class="form-control" name="process_id" id="uprocess_id" >
							
							<?php foreach($process_list as $process): ?>
								
								<option value="<?php echo $process->id; ?>" ><?php echo $process->name; ?></option>
								
							<?php endforeach; ?>
							
						</select>
					</div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
						<label for="phone">Matrix Type:</label>
						
						<select class="form-control" name="mp_type" id="ump_type" >
							<option value='1'>Daily</option>
							<!--<option value='2'>Weekly</option>
							<option value='3'>Monthly</option>-->
						</select>
						
					</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
					<div class="form-group">
						<label for="process_id">Metrix Design Title</label>
						<input type="text" class="form-control" placeholder="Design Title" name="description" id="udescription">
					</div>
					</div>
				</div>
				
				
				<div class="row" >
								
				<div class="col-md-12">
						<div class="col-md-2">
							<label for="KPI_Name"> KPI Name</label>
						</div>
						<div class="col-md-2">
							<label for="summ_type"> KPI Type</label>
						</div>
						<div class="col-md-2">
							<label for="summ_type"> Summary Type</label>
						</div>
						<div class="col-md-2">
							<label for="summ_formula">Type Formula</label>
						</div>
						<div class="col-md-2">
							<label for="target">Target</label>
						</div>
						<div class="col-md-2">
							<label for="weightage">Weightage (%)</label>
						</div>
						<div class="col-md-2">
							<label for="Action"> Action</label>
						</div>
					</div>
					
			</div>
			
			<div class="row" id='kpi_divs_ed'>
			
			</div>
									
		</div>
				
		
		  <div class="modal-footer">
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" id='btnUpdateDesign' class="btn btn-primary">Update</button>
			
		  </div>
		  
	</form>
		
	</div>
</div>
</div>
<!-- end Add -->

	
</div><!-- .wrap -->





