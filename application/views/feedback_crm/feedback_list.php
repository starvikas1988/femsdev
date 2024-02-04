
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
						<h4 class="widget-title"><i class="fa fa-bar-chart"></i> <?php echo fdcrm_title(); ?> List 
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
										<th>Customer Name</th>
										<th>Client</th>
										<th>Brand Name</th>
										<th>Comments</th>
										<th>Mail Sent</th>										
										<th>Feedback Status</th>
										<th>Added By</th>
										<th>Date Added</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$cn = 1;
								foreach($crm_list as $token){
									$feedbackForm = urlencode(base64_encode('data#'.$token['crm_id'] .'#' .$token['c_email']));
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<td><?php echo $token['crm_id']; ?></td>									
									<td><?php echo $token['c_email']; ?></td>									
									<td><?php echo $token['c_fname'] ." " .$token['c_lname']; ?><br/><?php echo $token['c_phone_no']; ?></td>
									<td><?php echo fdcrm_dropdown_source($token['c_client']); ?></td>
									<td><?php echo $token['c_brand']; ?></td>
									<td><?php echo $token['c_comments']; ?></td>
									<td><?php echo !empty($token['c_feedback_mail']) ? "<span class='text-success'><i class='fa fa-check'></i></span>" : "<span class='text-danger'><i class='fa fa-times'></i></span>"; ?></td>
									<td>
									
									<?php if(!empty($token['c_feedback_id'])){ echo "<span class='text-success'>Complete</span>";  ?>									
									<a title='Open Feedback' target="_blank" href='<?php echo fdcrm_url('feedback_view/'.$feedbackForm); ?>' class='btn btn-primary btn-xs' style='font-size:12px'><i class='fa fa-eye'></i></a>
									<?php } else {  ?>
									<span class='text-danger'>Pending</span>
									<a title='Open Feedback' target="_blank" href='<?php echo fdcrm_url('feedback/'.$feedbackForm); ?>' class='btn btn-danger btn-xs' style='font-size:12px'><i class='fa fa-eye'></i></a>
									<?php } ?>
									
									</td>								
									<td><?php echo $token['added_by_name']; ?></td>
									<td><?php echo date('d M, Y', strtotime($token['date_added'])); ?></td>
									<td>
									<?php /*if(!is_crm_readonly_access_mindfaq()){ ?>
									<a title='Edit Record' target="_blank" href="<?php echo fdcrm_url("updateCustomer/".$token['crm_id']); ?>" class='btn btn-primary btn-xs' style='font-size:12px'>
									<i class='fa fa-edit'></i></a>
									<?php } */ ?>
									<a title='Send Mail' id='viewCrmEmailModal' cid="<?php echo $token['crm_id']; ?>" cemail="<?php echo $token['c_email']; ?>" class='btn btn-danger btn-xs' style='font-size:12px'><i class='fa fa-envelope'></i></a>
																		
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
										<th>Feedback Sent</th>
										<th>Feedback Status</th>
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



<div class="modal fade" id="crmEmailModal" tabindex="-1" role="dialog" aria-labelledby="crmEmailModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	
	<form action="<?php echo fdcrm_url("feedback_send"); ?>" method="POST" autocomplete="off">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CRM Email Modal</h4>
      </div>
	  
      <div class="modal-body">	  
        <div class="row">
		<div class="col-md-6">
			<div class="form-group">
			  <label for="case">CRM ID</label>
			  <input type="text" class="form-control" id="form_crm_id" placeholder="" value="" name="form_crm_id" required readonly>
			</div>
		</div>
				
		<div class="col-md-6">
			<div class="form-group">
			  <label for="case">E-Mail ID</label>
			  <input type="text" class="form-control" id="form_email_id" placeholder="" value="" name="form_email_id" required readonly>
			</div>
		</div>
		</div>
      </div>
	  
      <div class="modal-footer">
		<button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to send feedback survey to <?php echo $form_email_id; ?>?');" name="crmFormSubmission">Send</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  
	  </form> 
    </div>
  </div>
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
