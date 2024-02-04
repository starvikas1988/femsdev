
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
			<div class="col-12">

				<div class="widget">
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Filter Search</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="" autocomplete="off">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="search_from_date" name="start" value="<?php if(!empty($from_date)){ echo date('m/d/Y', strtotime($from_date)); } ?>" class="form-control" required>
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="search_to_date" name="end" value="<?php if(!empty($to_date)){ echo date('m/d/Y', strtotime($to_date)); } ?>" class="form-control" required>
									</div> 
								</div>
								
								<div class="col-md-3"> 
									<div class="form-group">
										<label>Call Type</label>
										<select class="form-control" name="status" id="search_call_type" required>
										  <option value="all">All</option>
										  <option value="saved">Saved</option>
										  <option value="cancelled">Cancelled</option>									  
										</select>
									</div> 
								</div>
								
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" type="submit" value="View">Search</button>
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
		
		
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title"><i class="fa fa-bar-chart"></i> Alpha Gas 
						<span class="pull-right" style="font-size:12px"><i class="fa fa-eye"></i> <?php echo !empty($crm_list) ? "Showing " .count($crm_list) : "No "; ?> Records</span>
						</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table style="margin-top: 10px;" id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>Sl</th>
										<th>CRM ID</th>
										<th>Call Type</th>
										<th>Call AHT</th>
										<th>Hold Time</th>
										<th width="10%">Customer Name</th>
										<th>Language</th>
										<th>Phone</th>
										<th>Address</th>
										<th>Electric</th>
										<th>Electric A/C</th>
										<th>Gas</th>										
										<th>Gas A/C</th>
										<th>Added By</th>
										<th>Date Added</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								foreach($crm_list as $token){ 								
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<td><?php echo $token['crm_id']; ?></td>
									<td><b><?php echo ucwords($token['c_status']); ?></b></td>
									<td><?php echo $token['c_call_aht']; ?></td>
									<td><?php echo $token['c_hold_time']; ?></td>
									<td><?php echo $token['c_fname'] ." " .$token['c_lname']; ?></td>
									<td><?php echo $token['c_language']; ?></td>
									<td><?php echo $token['c_phone_no']; ?></td>
									<td><?php echo $token['c_address']; ?></td>
									<td><?php echo $token['c_utility_electric']; ?></td>
									<td><?php echo $token['c_electric_account']; ?></td>
									<td><?php echo $token['c_utility_gas']; ?></td>									
									<td><?php echo $token['c_gas_account']; ?></td>									
									<td><?php echo $token['added_by_name']; ?></td>
									<td><?php echo date('d M, Y', strtotime($token['date_added'])); ?></td>
									<td>
									<?php if(!is_crm_readonly_access_mindfaq()){ ?>
									<a title='Edit Record' target="_blank" href="<?php echo base_url()."alphagas/updateCustomer/" .$token['crm_id']; ?>" class='btn btn-primary btn-xs' style='font-size:12px'>
									<i class='fa fa-edit'></i></a>
									<?php } ?>
									<a title='View Logs' id='viewCrmLogs' cid="<?php echo $token['crm_id']; ?>" cname="<?php echo ucwords($token['c_status']); ?>" class='btn btn-success btn-xs' style='font-size:12px'><i class='fa fa-database'></i></a>
									</td>
								</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<th>Sl</th>
										<th>CRM ID</th>
										<th>Call Type</th>
										<th>Call AHT</th>
										<th>Hold Time</th>
										<th width="10%">Customer Name</th>
										<th>Language</th>
										<th>Phone</th>
										<th>Address</th>
										<th>Electric</th>
										<th>Electric A/C</th>
										<th>Gas</th>										
										<th>Gas A/C</th>
										<th>Added By</th>
										<th>Date Added</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>
</div>





<div class="modal fade" id="crmLogsModal" tabindex="-1" role="dialog" aria-labelledby="crmLogsModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">JurysInn Disposition Logs</h4>
      </div>
      <div class="modal-body">
			
      </div>	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
