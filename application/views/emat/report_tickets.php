
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
			<h4 class="widget-title">EMAT Ticket Report</h4>
			</header>
		</div>
		</div>
		
		
		
			<div class="col-md-12">
				<div class="widget">
					<div class="widget-body">
					<form id="form_new_user" method="GET" action="">
						
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
									<label for="start_date">Start Date</label>
									<input type="text" class="form-control" id="start_date" value='<?php echo date('m/d/Y', strtotime($start_date)); ?>' name="start_date" required autocomplete="off">
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
									<label for="end_date">End Date</label>
									<input type="text" class="form-control" id="end_date" value='<?php echo date('m/d/Y', strtotime($end_date)); ?>' name="end_date" required autocomplete="off">
									</div>
								</div>
								
								
									
								<div class="col-md-12" style="margin-top:25px">
									<div class="form-group">
										<input type="hidden" name="show" value="Show">
										<button class="btn btn-success waves-effect" type="submit">Download Report</button>
									</div>
								</div>
							</div>
							
					</form>	
					</div>
				</div>
			</div>
		</div>
	
	</section>
</div>