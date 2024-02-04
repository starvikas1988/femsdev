
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
														
								<div class="col-md-8"> 
									<div class="form-group">
										<label>CRM ID / Email ID / Customer Ref ID</label>
										<input type="text" name="s_ref" value="<?php if(!empty($s_crm_ref)){ echo $s_crm_ref; } ?>" class="form-control">
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
		
		<?php if(empty($search_terms)){ ?>
		<div class="col-md-12">
		<div class="widget">
			<div class="widget-body">
				<span class="text-primary"><b>-- Please Enter Some Data to Search --</b></span>
			</div>
		</div>
		</div>
		<?php } ?>
		
		<?php if(!empty($search_terms) && empty($crm_list)){ ?>
		<div class="col-md-12">
		<div class="widget">
			<div class="widget-body">
				<span class="text-danger"><b>-- No Records Found --</b></span>
			</div>
		</div>
		</div>
		<?php } ?>
		
		<?php if(!empty($crm_list)){ ?>
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title"><i class="fa fa-bar-chart"></i> <?php echo fdcrm_title(); ?> Records 
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
										<th>Email</th>
										<th>Phone</th>
										<th>Customer Name</th>
										<th>Customer Ref</th>
										<th>Comments</th>
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
									<td><?php echo $token['c_email']; ?></td>
									<td><?php echo $token['c_phone_no']; ?></td>
									<td><?php echo $token['c_fname'] ." " .$token['c_lname']; ?></td>
									<td><?php echo $token['c_call_ref']; ?></td>
									<td><?php echo $token['c_comments']; ?></td>									
									<td><?php echo $token['added_by_name']; ?></td>
									<td><?php echo date('d M, Y', strtotime($token['date_added'])); ?></td>
									<td>
									<?php if(!is_crm_readonly_access_mindfaq()){ ?>
									<a title='Edit Record' href="<?php echo fdcrm_url("updateCustomer/".$token['crm_id']); ?>" class='btn btn-primary btn-xs' style='font-size:12px'>
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
										<th>Email</th>
										<th>Phone</th>
										<th>Customer Name</th>
										<th>Customer Ref</th>
										<th>Comments</th>
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
		<?php } ?>	
			
		
		</div>
		
	</section>
</div>





<div class="modal fade" id="crmLogsModal" tabindex="-1" role="dialog" aria-labelledby="crmLogsModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CRM Disposition Logs</h4>
      </div>
      <div class="modal-body">
			
      </div>	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
