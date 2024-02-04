
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
										<input type="date" id="search_from_date" name="search_from_date" value="<?php if(!empty($from_date)){ echo date('Y-m-01', strtotime($from_date)); } ?>" class="form-control" required>
									</div>
								</div>  
								<div class="col-md-3"> 
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="date" id="search_to_date" name="search_to_date" value="<?php if(!empty($to_date)){ echo date('Y-m-d', strtotime($to_date)); } ?>" class="form-control" required>
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
						<h4 class="widget-title">Patient List Records</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table style="margin-top: 10px;" id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Patient ID</th>
										<th>Name</th>
										<th>Birthdate</th>
										<th>Address</th>
										<th>Blood</th>
										<th>Allergies</th>								
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
									<td><?php echo $token['patient_code']; ?></td>
									<td><b><?php echo $token['c_name']; ?></b></td>
									<td><?php echo $token['c_birth']; ?> (<?php echo $token['c_gender']; ?>)</td>
									<td><?php echo $token['c_address']; ?></td>
									<td><?php echo $token['c_blood']; ?></td>
									<td><?php echo $token['c_allergy']; ?></td>									
									<td><?php echo $token['added_by_name']; ?></td>
									<td><?php echo date('d M, Y', strtotime($token['date_added'])); ?></td>
									<td>
									<?php if(get_role_id() == '276'  || get_global_access() == 1 || is_access_clinic_portal()){ ?>
									<a target="_blank" title='Edit Record' href="<?php echo base_url()."clinic_portal/patient/edit/" .$token['id']; ?>" class='btn btn-primary btn-xs' style='font-size:12px'>
									<i class='fa fa-edit'></i></a>									
									<?php } ?>
									
									<a title='View Info' target="_blank" href="<?php echo base_url('clinic_portal/generate_patient_report_pdf/'.$token['id'].'/view'); ?>" class='btn btn-warning btn-xs' style='font-size:12px'><i class='fa fa-eye'></i></a>
									
									<a title='Download Info' target="_blank" href="<?php echo base_url('clinic_portal/generate_patient_report_pdf/'.$token['id'].'/download'); ?>" class='btn btn-success btn-xs' style='font-size:12px'><i class='fa fa-download'></i></a>
									
									<?php if(get_global_access() == 1){ ?>
									<a onclick="return confirm('Are you sure, you want to delete this patient?')" href="<?php echo base_url('clinic_portal/del_patient/'.$token['id']); ?>" class="btn btn-danger btn-xs" style='font-size:12px'><i class="fa fa-times"></i></a>									
									<?php } ?>
									
									</td>
								</tr>
								<?php } ?>
								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Patient ID</th>
										<th>Name</th>
										<th>Birthdate</th>
										<th>Address</th>
										<th>Blood</th>
										<th>Allergies</th>								
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





<div class="modal fade" id="jurysInnLogsModal" tabindex="-1" role="dialog" aria-labelledby="jurysInnLogsModal" aria-hidden="true">
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
