
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
								<h4 class="widget-title">Search Records</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
				
					<div class="widget-body">
						
						<form id="form_new_user" method="GET" action="" autocomplete="off">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Patient ID</label>
										<input type="text"  placeholder="Search by Patient ID" id="search_crm" name="search_crm" value="<?php if(!empty($search_crm)){ echo $search_crm; } ?>" class="form-control">
									</div>
								</div> 
								<div class="col-md-3"> 
									<div class="form-group">
										<label>Patient Name</label>
										<input type="text" id="search_name" name="search_name" value="<?php if(!empty($search_name)){ echo $search_name; } ?>" class="form-control" placeholder="Or, Search by Name">
									</div> 
								</div>
							</div>
							
							<div class="row">	
								<div class="col-md-1" style="margin-top:0px">
									<button class="btn btn-success waves-effect" type="submit" value="View"><i class="fa fa-search"></i> Search</button>
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
						<h4 class="widget-title">Clinic Search Records</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
					
					<?php if(count($crm_list) > 0){ ?>
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
									<?php if(get_role_id() == '276'  || get_global_access() == 1  || is_access_clinic_portal()){ ?>
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
					
					<?php } else { ?>
						
						<span class="text-danger"><b>-- No Records Available ---</b></span>
						
					<?php } ?>
		
					</div>
				</div>
			</div>
		</div>
		
	</section>
</div>

