
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Search Feedback</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('bcp_survey/bcp_list'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control">
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control">
									</div> 
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="office_id">Select a Location</label>
										<select class="form-control" name="office_id" id="foffice_id" >
											<option value='All'>ALL</option>
											<?php foreach($location_list as $loc): 
												$sCss="";
												if($loc['abbr']==$office_id) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-1" style='margin-top:2px;'>
									<div class="form-group">
										</br>
										<button class="btn btn-primary waves-effect" a href="<?php echo base_url()?>bcp_survey/bcp_list" type="submit" id='show' name='show' value="Show">SHOW</button>
									</div>
								</div>
								
								<?php if($download_link!=""){ ?>
									<div style='float:right; margin-top:25px;' class="col-md-1">
										<div class="form-group" style='float:right;'>
											<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>	
										</div>
									</div>
								<?php } ?>
							
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
	
	
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>Customer name</th>
										<th>Customer Phone</th>
										<th>Callback Date/Time</th>
										<th>User Fusion ID</th>
										<th>User Name</th>
										<th>User Location</th>
										<th>User Client</th>
										<th>User Process</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
									foreach($bcp_data as $bcp){ ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $bcp['customer_name'] ?></td>
										<td><?php echo $bcp['customer_phone'] ?></td>
										<td><?php echo $bcp['callback_datetime'] ?></td>
										<td><?php echo $bcp['fusion_id'] ?></td>
										<td><?php echo $bcp['name'] ?></td>
										<td><?php echo $bcp['office_id'] ?></td>
										<td><?php echo $bcp['client'] ?></td>
										<td><?php echo $bcp['process'] ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
	</section>
</div>
