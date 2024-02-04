<style>

.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:4px;
	}
	
.table > thead > tr > th,.table > tfoot > tr > th{
		text-align:center;
}

</style>
<div class="wrap">
<section class="app-content">
<div class="row">
<!-- DataTable -->
<div class="col-md-12">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">Activities (Last 31 Days)</h4>
			</header><!-- .widget-header -->
			<hr class="widget-separator">
			
			<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									
										<th>Date</th>
									    <!--
										<th>Team Leader</th>
										<th>Login Date</th> -->
										<th>Login Time</th>
										<th>Logout Time</th>
										<th>Logged In Hours</th>
										<th>Other Break Time </th>
										<th>Lunch/Dinner Break Time </th>
										<th>Disposition</th>
										
									</tr>
								</thead>
								
								<tfoot>
									<tr class='bg-info'>
										<th>Date</th>
									    <!--
										<th>Team Leader</th>
										<th>Login Date</th> -->
										<th>Login Time</th>
										<th>Logout Time</th>
										<th>Logged In Hours </th>
										<th>Other Break Time </th>
										<th>Lunch/Dinner Break Time </th>
										<th>Disposition</th>
										
									</tr>
								</tfoot>
	
								<tbody>
								
								
								<?php
								
									$pDate=0;
									foreach($login_details as $user):
									
									$cDate=$user['rDate'];
									$logged_in_hours=$user['logged_in_hours'];
									$tBrkTime=$user['tBrkTime'];
									$ldBrkTime=$user['ldBrkTime'];
									
									$disposition=$user['disposition'];
									
									
									
									if($pDate!=$cDate){
										
										//if($pDate!=0) echo "<tr class=''><td colspan='13' class='bg-sep'></td></tr>";
										$pDate=$cDate;
									}
									
								?>
									
									<tr>
									
										<td><?php echo $user['rDate']; ?></td>
										<!--
										<td><?php //echo $user['asign_tl']; ?></td>
										 <td><?php //echo $user['login_date']; ?></td> -->
										<td><?php echo $user['login_time']; ?></td>
										<td><?php echo $user['logout_time']; ?></td>
																			
										<td><?php echo $logged_in_hours; ?></td>
										
										<td><?php echo $tBrkTime; ?></td>
										<td><?php echo $ldBrkTime; ?></td>
										
										<td><center><?php 
											if($logged_in_hours!="0") echo "P"; 
											else if($disposition!="") echo $user['disposition']; 
											else echo "MIA"; 
										?></center></td>
										
										
										
									</tr>
									
											
								<?php endforeach; ?>
										
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
					
			
			
		</div><!-- .widget -->
	</div>
	<!-- END DataTable -->
</div>
</section>
</div>