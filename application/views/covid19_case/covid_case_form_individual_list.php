
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
						<h4 class="widget-title">Case List</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table style="margin-top: 10px;" id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>CRM ID</th>
										<th>Case Name</th>
										<th>Form Status</th>
										<th>Case Status</th>
										<th>Opened By</th>
										<th>Date Added</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								foreach($case_list as $token){ 								
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<td><?php echo $token['crm_id']; ?></td>
									<td><?php echo $token['fname'] ." " .$token['lname']; ?></td>
									<td><?php 
									if($token['individual_status'] == 'COMPLETE')
									{
										echo "<span class='text-success'><b>COMPLETE</b></span>";
									}
									else {
										echo "<span class='text-primary'><b>PENDING</b></span>";
									}
									$encodedUrl = urlencode(base64_encode($token['crm_id'].'/personal'));
									$SendFullURL= $formBaseUrl.$encodedUrl;
									?></td>
									<td><?php 
									if(!empty($token['case_status']))
									{
										if($token['case_status'] == 'POSITIVE')
										{
											echo "<span class='text-danger'><b>POSITIVE</b></span>";
										}
										if($token['case_status'] == 'NEGATIVE')
										{
											echo "<span class='text-success'><b>NEGATIVE</b></span>";
										}
										if($token['case_status'] == 'RECOVERED')
										{
											echo "<span class='text-primary'><b>RECOVERED</b></span>";
										}
									} else {
										echo "<span class='text-warning'><b>PENDING</b></span>";
									}
									?></td>
									<td><?php echo $token['added_by_name'];//ucwords($token['case_source']); ?></td>
									<td><?php echo date('d M, Y', strtotime($token['date_added'])); ?></td>
									<td>
									
									<a title='View as Public' target="_blank" href="<?php echo $SendFullURL; ?>" class='btn btn-warning btn-xs' style='font-size:12px'>
									<i class='fa fa-external-link'></i> Open as Public</a>
									
									<a title='View Case' href="<?php echo base_url()."covid_case/form/" .$token['crm_id']."/personal/"; ?>" class='btn btn-success btn-xs' style='font-size:12px'>
									<i class='fa fa-eye'></i> Open Case</a>		

									<a title='View Logs' target="_blank" href="<?php echo base_url()."covid_case/check_logs/" .$token['crm_id']."/"; ?>" class='btn btn-danger btn-xs' style='font-size:12px'><i class='fa fa-calendar'></i> View Logs</a>
									</td>
								</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<th>SL</th>
										<th>CRM ID</th>
										<th>Case Name</th>
										<th>Form Status</th>
										<th>Case Status</th>
										<th>Opened By</th>
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