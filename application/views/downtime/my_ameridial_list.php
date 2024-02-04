
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
								<h4 class="widget-title">Ameridial Downtime Search</h4>
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
										<div class="input-group">
										<div class="input-group-addon">
										   <span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
										<input type="text" class="form-control" id="search_from_date" placeholder="" name="search_from_date" value="<?php echo date('m/d/Y', strtotime($from_date)); ?>" required>
									   </div>
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<div class="input-group">
										<div class="input-group-addon">
										   <span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
										<input type="text" class="form-control" id="search_to_date" placeholder="" name="search_to_date" value="<?php echo date('m/d/Y', strtotime($to_date)); ?>" required>
									   </div>
									</div> 
								</div>

								<div class="col-md-3"> 
									<div class="form-group">
										<label>Ticket ID (Optional)</label>
										<input type="text" id="search_ticket_id" name="search_ticket_id" value="<?php echo $ticket_no; ?>" class="form-control">
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
						<h4 class="widget-title">Ameridial Downtime List</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table style="margin-top: 10px;" id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>Sl</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>Issue Date</th>
										<th>Issue Time</th>
										<th>Ticket No</th>
										<th>Issue</th>
										<th>Remarks</th>
										<th>Date Added</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								foreach($ameridialList as $token){ 								
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<td><?php echo $token['fusion_id']; ?></td>
									<td><b><?php echo $token['full_name']; ?></b></td>
									<td><?php echo $token['issue_date']; ?></td>
									<td><?php echo date('h:i A', strtotime($token['issue_time'])); ?></td>
									<td><?php echo $token['ticket_no']; ?></td>
									<td><?php echo $token['issue']; ?></td>
									<td><?php echo $token['remarks']; ?></td>
									<td><?php echo date('d M, Y', strtotime($token['date_added'])); ?></td>
									<td>
									<?php if(empty($token['approved_by'])){ ?> 
									<a title="Edit Record" href="<?php echo base_url()?>downtime/my_ameridial_list_edit/<?php echo $token['id']; ?>" target="_blank" class="btn btn-primary btn-xs" style="font-size:12px"><i class="fa fa-edit"></i></a> 

									<?php if(get_global_access() == 1 || get_role_dir() != 'agent' || $approvalAccess == true){ ?>
									<a title="Approve Now" href="<?php echo base_url()?>downtime/my_ameridial_list_approve/<?php echo $token['id']; ?>" onclick="return confirm('Do you want to approve this ticket ?')" class="btn btn-success btn-xs" style="font-size:12px"><i class="fa fa-check"></i> Approve</a> 
									<?php } ?>
									
									<?php } else { echo '<span class="text-success"><b>Approved<br/>(' .$token['approved_by_name'] .')</b></span>'; } ?>
									</td>
								</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<th>Sl</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>Issue Date</th>
										<th>Issue Time</th>
										<th>Ticket No</th>
										<th>Issue</th>
										<th>Remarks</th>
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

