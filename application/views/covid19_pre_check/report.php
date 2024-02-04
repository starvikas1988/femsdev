<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">Covid-19 PRELIMINARY CHECK-IN REPORT</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">					
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('covid19_pre_check/covid19_pre_check_report'); ?>">	
							<?php echo form_open('',array('method' => 'get')) ?>
						
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Date From (Form Submitting Date)</label>
									<input type="text" id="date_from" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label> Date To (Form Submitting Date)</label>
									<input type="text" id="date_to" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Site</label>
									<select class="form-control" id="" name="office_id">
										<option value="">Select</option>
										<option value="CEB">Cebu</option>
										<option value="MAN">Manila</option>
									</select>
								</div>
							</div>
							<div class="col-md-2" style='margin-top:20px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" a href="<?php echo base_url()?>covid19_pre_check/covid19_pre_check_report" type="submit" id='show' name='show' value="Show">Export To Excel</button>
								</div>
							</div>
						</div>
						
						<!--<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Fusion ID</th>
										<th>Name</th>
										<th>L1 Supervisor</th>
										<th>Client</th>
										<th>Process</th>
										<th>Phone</th>
									</tr>
								</thead>
								<tbody>
									<?php  
										//$i=1;
										//foreach($checkCovid19List as $row){
									?>
									<tr>
										<td><?php //echo $i++; ?></td>
										<td><?php //echo $row['fusion_id']; ?></td>
										<td><?php //echo $row['full_name']; ?></td>
										<td><?php //echo $row['li_super']; ?></td>
										<td><?php //echo $row['client']; ?></td>
										<td><?php //echo $row['process']; ?></td>
										<td><?php //echo $row['phone']; ?></td>
									</tr>
									<?php //} ?>
								</tbody>
							</table>
						</div> -->
						
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	