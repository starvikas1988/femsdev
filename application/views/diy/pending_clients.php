<style>
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
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Pending Approval</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
				
					
													
					<div class="widget-body">
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>SL</th>
										<th>Name</th>
										<th>Email</th>
										<th>Gender</th>
										<th>Role</th>
										<!-- <th>Client</th> -->
										<th>Mobile</th>
										<th>Action</th>
									</tr>
								</thead>
								
								<tfoot>
									<tr>
										<th>SL</th>
										<th>Name</th>
										<th>Email</th>
										<th>Gender</th>
										<th>Role</th>
										<!-- <th>Client</th> -->
										<th>Mobile</th>
										<th>Action</th>
									</tr>
								</tfoot>
	
								<tbody>
								
								<?php 
									$cnt=1;
									if(!empty($p_clients)){
									foreach($p_clients as $client): 
										$c_id = $client['c_id'];
										//print_r($client);
								?>
									<tr>
										<td><?php echo $cnt++; ?></td>
										<td><?php if($client['fname'] != "") echo $client['fname'].' '.$client['lname']; else echo 'NA';  ?></td>
										<td><?php echo $client['email_id']; ?></td>
										<td><?php if($client['sex'] != "") echo $client['sex']; else echo 'NA';  ?></td>
										<td><?php if($client['role'] != "") echo $client['role']; else echo 'NA'; ?></td>
										<!-- <td>
										<?php echo $client['client']; ?>
										</td> -->
										<td><?php if($client['mobile'] != "") echo $client['mobile']; else echo 'NA'; ?></td>
										<td>	
											<?php if($client['link_sub_log'] != "") { ?>
												
													<!-- <a href="<?php echo base_url()."diy/approve/$c_id" ?>" class="btn btn-success">Approve</a> -->

													<a href="<?php echo base_url()."diy/view_details/$c_id" ?>" class="btn btn-success"><i class="fa fa-eye"></i></a>
												
											<?php }else{ echo '<label class="label label-bg label-danger">Not Registered Yet</label>'; } ?>
										</td>
									</tr>
								<?php endforeach; 
									}else{
								?>
									<tr>
										<td colspan=6 align="center">No pending approval</td>
										
									</tr>
									<?php }?>	
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>
	
</div><!-- .wrap -->
	
<!-- Default bootstrap-->





