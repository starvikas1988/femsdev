
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
						<h4 class="widget-title">Your Appraisal Details</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">

							<?php if($details){ ?>
							<table style="margin-top: 10px;" id="" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>Name</th>
										<th>Fusion ID</th>
										<th>Designation</th>	
										<th>Department</th>
										<th>Process</th>
										<th>L1 Supervisor</th>
										<th>Gross Pay</th>
										<th>Effected From</th>
										<th>Download</th>
									</tr>
								</thead>
								<tbody>
								<?php 

								// print_r($details[0]['warned_id']);
								foreach($details as $token){ 								
								?>
								<tr>

									<td><?php echo $token['fullname']; ?></td>	
									<td><?php echo $token['fusion_id']; ?></td>	
									<td><?php echo $token['role']; ?></td>							
									<td><?php echo $token['department']; ?></td>	
									<td><?php echo $token['process_name']; ?></td>	
									<td><?php echo $token['l1_super']; ?></td>
									<?php 
										$user_id =$token['user_id'];
										$ip_id =$token['id'];
									?>
									<td><?php echo $token['gross_pay']; ?></td>	
									<td><?php echo $token['affected_from']; ?></td>
									<td>
										<a href='<?php echo base_url()."appraisal_employee/send_mail/Y/$ip_id" ?>' title='Download Appraisal Letter' class='btn btn-primary btn-xs'><i class='fa fa-download' aria-hidden='true'></i>
										</a>
									</td>
								</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<th>Name</th>
										<th>Fusion ID</th>
										<th>Designation</th>	
										<th>Department</th>
										<th>Process</th>
										<th>L1 Supervisor</th>
										<th>Gross Pay</th>
										<th>Effected From</th>
										<th>Download</th>					
									</tr>
								</tfoot>
							</table>
							<?php }else{ ?>
								<div class="col-md-12 text-center">
									<br><br>
									<h4 class="heading-white-title"><span class="text-success">No Appraisals Yet</span></h4>
									<br>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>
</div>

