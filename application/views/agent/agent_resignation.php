
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
		font-size:14px
	}
</style>


<div class="wrap">
	<section class="app-content">


	<?php
		//print_r($get_resign_status);
		if(empty($get_resign_status)) {
	?>
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">User Resignation Form</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
					  <form id="form_new_user" method="POST">
					
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Resignation Date</label>
									<input type="text" readonly style="background-color:white" class="form-control" id="resign_date" name="resign_date" value="" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Release Date</label>
									<input type="text" readonly class="form-control" id="released_date" name="released_date" value="" >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Reason for Resignation</label>
									<textarea class="form-control" id="user_remarks" name="user_remarks"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8" style="padding-left:0">
								<input class="btn btn-primary waves-effect" id="button1" type="submit" name="submit" value="SAVE">
							</div>
						</div>
						
					  </form>	
					</div>
				</div>
			</div>
		</div>
		
	<?php }else{ ?>	
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Resign List of The User</h4>
					</header>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Resign Date</th>
										<th>Released Date</th>
										<td>Resign Status</td>
									</tr>
								</thead>
								<tbody>
									<?php 	
										$i=1;
										foreach($get_resign_status as $user): 
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $user['resign_date']; ?></td>
										<td><?php echo $user['released_date']; ?></td>
										<td>
											<?php
												$resign_status=$user['resign_status'];
												
												if($resign_status=='P')
													echo "<span style='color:Maroon'><b>Pending</b></span>";
												else if($resign_status=='C')
													echo "<span style='color:Green'><b>Accepted</b></span>";
												else
													echo "";
											?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	<?php } ?>

	
	</section>
</div>	