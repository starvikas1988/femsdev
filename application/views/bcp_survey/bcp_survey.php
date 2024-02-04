
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
						
						<form id="form_new_user" method="GET" action="<?php echo base_url('bcp_survey'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control">
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control">
									</div> 
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>bcp_survey" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
	
	
		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									<div class="pull-left">BCP SURVEY</div>
									<div class="pull-right">
										<button title='' type='button' class='btn btn-success addBcpSurvey' style='font-size:10px'>Add</button>
									</div>	
								</h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>
				
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

<!--------------------------------------------------------------------------------------------------->

<div class="modal fade" id="addBCPSurveyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmBCPSurveyModal" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">BCP Survey</h4>
      </div>
      <div class="modal-body">
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Customer Name</label>
						<input type="text" class="form-control" id="customer_name" name="customer_name" required>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group">
						<label>Customer Phone</label>
						<input type="text" class="form-control" id="customer_phone" name="customer_phone" onkeyup="checkDec(this);" required>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Call Back Date/Time</label>
						<input type="text" class="form-control" id="callback_datetime" name="callback_datetime" required>
					</div>
				</div>
			</div>
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='Bcp_survey' class="btn btn-primary">Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>
