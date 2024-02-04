
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
								<h4 class="widget-title">Generate Leave Report</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="<?php echo base_url() ."CaledarController/generate_leave_reports"; ?>" autocomplete="off">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="search_from_date" name="start" value="<?php if(!empty($from_date)){ echo date('m/d/Y', strtotime($from_date)); } ?>" class="form-control diy_datePicker" required>
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="search_to_date" name="end" value="<?php if(!empty($to_date)){ echo date('m/d/Y', strtotime($to_date)); } ?>" class="form-control diy_datePicker" required>
									</div> 
								</div>
								
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-primary" type="submit" name="show">View</button>
								</div>
								<div class="col-md-1" style="margin-top:20px">
									<button class="btn btn-success waves-effect" type="button" value="View">Download</button>
								</div>
							</div>
							
						</form>
						
					</div>
				</div>

			</div>		
		</div>
		<div style="background-color:white;padding: 0 10px;">

<form name="frm" id="frm" method="post" action="<?php echo base_url();?>/diy/schedule_multi_del">
						   <div class="table-responsive">
							   <table class="table table-striped skt-table" cellspacing="0" width="100%">
								   <thead>
									   <tr class='bg-info'>
										   <th>SL</th>
										   <th>Teachers Name</th>
										   <th>From Date</th>
										   <th>To Date</th>
										   <th>Number of Days</th>
										   <th>Reason</th>
										   <th>Contact details</th>
										   <th>Status</th>
									   </tr>
								   </thead>
								   <tbody>
									   <?php 
									   $counter=0;
									   foreach($leave_master_details as $row){ 
										   $counter++;
										   
									   ?>
									   <tr>
									   <td><?= $counter;?></td>
										   <td><?php echo $row['teacher_name']; ?></td>
										   <td><?php echo $row['from_date']; ?></td>
										   <td><?php echo $row['to_date']; ?></td>
										   <td><?php echo $row['no_of_days']; ?></td>
										   <td><?php echo $row['reason']; ?></td>
										   <td><?php echo $row['contact_details']; ?></td>
										   <td><?php echo $row['status']; ?></td>
										   
									   </tr>
									   <?php } ?>
								   </tbody>
							   </table>
						   </div>
						   
				   </form>	
				   </div>
	</section>
</div>

