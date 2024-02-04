	<style>
	.dashboardCard{
		padding-left:10px !important;
		padding-right:10px !important;
	}
	.dashboardCard .icon_card{
	}
	</style>
	
	<div class="row mb-4">
		<div class="col-md-12 grid-margin">
			<div class="d-flex justify-content-between flex-wrap">
				<div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
					<h5 class="mr-4 mb-0 font-weight-bold">Dashboard</h5>                           
				</div>                        
			</div>
		</div>
     </div>
						
	<div class="row mb-4">
		
	<?php if(get_role() == "stakeholder"){ ?>
	
		<div class="col-xl-3 col-md-6 col-lg-12 stretched_card">
			<div class="card mb-mob-4 icon_card success_card_bg">                        
				<div class="card-body">
					<p class="card-title mb-0 text-white">
						My Open Tickets
					</p>
					<div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
						<h3 class="mb-0 text-white">
							<?php echo !empty($counter['assigned']) ? $counter['assigned'] : 0; ?>
						</h3>
						<div class="arrow_icon">
							<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
						</div>
					</div>
					<!--<p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Since last day)</small></span></p>-->
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 col-lg-12 stretched_card">
			<div class="card mb-mob-4 icon_card warning_card_bg">                        
				<div class="card-body">
					<p class="card-title mb-0 text-white">
						My Closed Tickets
					</p>
					<div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
						<h3 class="mb-0 text-white">
							<?php echo !empty($counter['closed']) ? $counter['closed'] : 0; ?>
						</h3>
						<div class="arrow_icon">
							<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
						</div>
					</div>
					<!--<p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Since last day)</small></span></p>-->
				</div>
			</div>
		</div>


    <?php } else { ?>	
	
		
		<div class="col-xl-2 col-md-6 col-lg-12 stretched_card dashboardCard">		
			<div class="card mb-mob-4 icon_card  bg-dangers" style="    background-color: #c88546;">
			<a href="<?php echo hth_url('view_ticket/open'); ?>">
				<div class="card-body">
					<p class="card-title mb-0 text-white">
						Unassigned Tickets
					</p>
					<div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
						<h3 class="mb-0 text-white">
							<?php echo !empty($counter['pending']) ? $counter['pending'] : 0; ?>
						</h3>
						<div class="arrow_icon">
							<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
						</div>
					</div>
					<!--<p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Since last day)</small></span></p>-->
				</div>
				</a>
			</div>		
		</div>
		
		<div class="col-xl-2 col-md-6 col-lg-12 stretched_card dashboardCard">		
			<div class="card mb-mob-4 icon_card warning_card_bg">
			<a href="<?php echo hth_url('view_ticket/assigned'); ?>">
				<div class="card-body">
					<p class="card-title mb-0 text-white">
						Total Open
					</p>
					<div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
						<h3 class="mb-0 text-white">
							<?php echo !empty($counter['assigned']) ? $counter['assigned'] : 0; ?>
						</h3>
						<div class="arrow_icon">
							<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
						</div>
					</div>
					<!--<p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Since last day)</small></span></p>-->
				</div>
				</a>
			</div>		
		</div>
		
		<div class="col-xl-2 col-md-6 col-lg-12 stretched_card dashboardCard">
			<div class="card mb-mob-4 icon_card success_card_bg"> 
			<a href="<?php echo hth_url('view_ticket/today'); ?>">
				<div class="card-body">
					<p class="card-title mb-0 text-white">
						Todays Call
					</p>
					<div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
						<h3 class="mb-0 text-white">
							<?php echo !empty($counter['today']) ? $counter['today'] : 0; ?>
						</h3>
						<div class="arrow_icon">
							<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
						</div>
					</div>
					
				</div>
				</a>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 col-lg-12 stretched_card dashboardCard">
			<div class="card mb-mob-4 icon_card primary_card_bg">
				<a href="<?php echo hth_url('view_ticket/all'); ?>">
				<div class="card-body">
					<p class="card-title mb-0 text-white">
						Total Calls
					</p>
					<div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
						<h3 class="mb-0 text-white">
							<?php echo !empty($counter['total']) ? $counter['total'] : 0; ?>
						</h3>
						<div class="arrow_icon">
							<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
						</div>
					</div>
					<!--<p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Since last day)</small></span></p>-->
				</div>
				</a>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 col-lg-12 stretched_card dashboardCard">
			<div class="card mb-mob-4 icon_card info_card_bg">
				<a tthref="#" href="<?php echo hth_url('view_ticket/repeat'); ?>">
				<div class="card-body">
					<p class="card-title mb-0 text-white">
						Repeat Calls
					</p>
					<div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
						<h3 class="mb-0 text-white">
							<?php echo !empty($counter['repeat']) ? $counter['repeat'] : 0; ?>
						</h3>
						<div class="arrow_icon">
							<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
						</div>
					</div>
					<!--<p class="mb-0 text-white">100% <span class="text-white ml-1"><small>(Since last day)</small></span></p>-->
				</div>
				</a>
			</div>
		</div>
		

	
	<?php } ?>
	
	</div>
	
	
    <div class="row align-items-center mb-4">
	
	<div class="col-md-6">
		<div class="card padderCard">
		<div class="card-body">
		<div class="row">
		<div class="col-md-12">
			<span class="font-weight-bold"><i class="fa fa-pie-chart"></i> Ageing of Tickets</span>
		</div>
		<div class="col-md-12">
		    <br/>
			<div class="table-widget">
			<div class="table-white">
				<table id="datatable-check" class="table table-striped table-bordered">
					<thead>
					  <tr>
						<th>Department</th>
						<th>Total Ticket Assigned</th>
						<th>0-7 Days</th>
						<th>8-15 Days</th>
						<th>16-30 Days</th>
						<th>More than 30 Days</th>
					  </tr>
					</thead>
					<tbody>
					<?php 
					foreach($department_list as $token){ 
						$deptID = $token['id'];
					?>
					<tr>
						<td><?php echo $token['name']; ?></td>
						<td><?php echo !empty($dept_aging_analytics[$deptID]['assigned']) ? count($dept_aging_analytics[$deptID]['assigned']) : "0"; ?></td>
						<td><?php echo !empty($dept_aging_analytics[$deptID]['1day']) ? count($dept_aging_analytics[$deptID]['1day']) : "0"; ?></td>
						<td><?php echo !empty($dept_aging_analytics[$deptID]['7day']) ? count($dept_aging_analytics[$deptID]['7day']) : "0"; ?></td>
						<td><?php echo !empty($dept_aging_analytics[$deptID]['15day']) ? count($dept_aging_analytics[$deptID]['15day']) : "0"; ?></td>
						<td><?php echo !empty($dept_aging_analytics[$deptID]['30day']) ? count($dept_aging_analytics[$deptID]['30day']) : "0"; ?></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		  </div>
			
			
		</div>
		</div>
		</div>
		</div>
	</div>
	
	
	
	<div class="col-md-6">
		<div class="card padderCard">
		<div class="card-body">
		<div class="row">
		<div class="col-md-12">
			<span class="font-weight-bold"><i class="fa fa-pie-chart"></i> Department Tickets</span>
		</div>
		<div class="col-md-12">
		    <br/>
			<div class="table-widget">
			<div class="table-white">
				<table id="datatable-check" class="table table-striped table-bordered">
					<thead>
					  <tr>
						<th>Department</th>
						<th>Total Ticket Assigned</th>
						<th>Resolved</th>
						<th>Pending</th>
					  </tr>
					</thead>
					<tbody>
					<?php 
					foreach($department_list as $token){ 
						$deptID = $token['id'];
					?>
					<tr>
						<td><?php echo $token['name']; ?></td>
						<td><?php echo !empty($dept_status_analytics[$deptID]['assigned']) ? count($dept_status_analytics[$deptID]['assigned']) : "0"; ?></td>
						<td><?php echo !empty($dept_status_analytics[$deptID]['resolved']) ? count($dept_status_analytics[$deptID]['resolved']) : "0"; ?></td>
						<td><?php echo !empty($dept_status_analytics[$deptID]['pending']) ? count($dept_status_analytics[$deptID]['pending']) : "0"; ?></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		  </div>
			
			
		</div>
		</div>
		</div>
		</div>
	</div>
	
	</div>
	
	
	
	<div class="row align-items-center mb-4">
	
	<div class="col-md-6">
		<div class="card padderCard">
		<div class="card-body">
		<div class="row">
		<div class="col-md-12">
			<span class="font-weight-bold"><i class="fa fa-pie-chart"></i> Department Wise Call Volume</span>
		</div>
		<div class="col-md-12">
			<br/>
			<div id="o_ticket_deapartment_pie" style="width:100%;height:350px"></div>
			<br/>
		</div>
		</div>
		</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="card padderCard">
		<div class="card-body">
		<div class="row">
		<div class="col-md-12">
			<span class="font-weight-bold"><i class="fa fa-pie-chart"></i> Department Wise Classification</span>
		</div>
		<div class="col-md-12">
			<br/>
			<div style="width:100%;height:350px">
				<canvas id="o_ticket_deapartment_barget"></canvas>
			</div>
			<br/>
		</div>
		</div>
		</div>
		</div>
	</div>
	
	</div>
	
	
	<div class="row align-items-center mb-4">
	
	<div class="col-md-12">
		<div class="card padderCard">
		<div class="card-body">
		<div class="row">
		<div class="col-md-12">
			<span class="font-weight-bold"><i class="fa fa-pie-chart"></i> DEPARTMENT : Date Wise Call Volume</span>
		</div>
		<div class="col-md-12">
			<br/>
			<div style="width:100%;height:350px">
				<canvas id="o_ticket_deapartment_fullget"></canvas>
			</div>
			<br/>
		</div>
		</div>
		</div>
		</div>
	</div>
	
	</div>
	
	
	<div class="row align-items-center mb-4">
	
	<div class="col-md-12">
		<div class="card padderCard">
		<div class="card-body">
		<div class="row">
		<div class="col-md-12">
			<span class="font-weight-bold"><i class="fa fa-pie-chart"></i> DISTIRICT : Date Wise Call Volume</span>
		</div>
		<div class="col-md-12">
			<br/>
			<div style="width:100%;height:350px">
				<canvas id="o_ticket_deapartment_districtget"></canvas>
			</div>
			<br/>
		</div>
		</div>
		</div>
		</div>
	</div>
	
	</div>