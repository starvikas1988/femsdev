<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table-export/css/dataTables.bootstrap.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table-export/css/buttons.bootstrap.min.css"/>

<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	.label {
		/*padding: .7em .6em;*/
	}
	.common-top {
		width:100%;
		margin:10px 0 0 0!important;
	}
	.welcome-area {
		padding:15px;
		background: rgba(0, 111, 255, 0.1);
		border: 1px solid rgba(0, 111, 255, 0.12);
		border-radius: 4px;
	}
	.heading-title {
		font-size:20px;
		padding:0 0 5px 0;
		margin:0;
		color:#384364;
	}
	.welcome-area p {
		padding:0;
		margin:0;
		font-size:13px;
	}
	.align-item-center {
		display: flex;
		align-items: center;
	}
	.welcome-area span {
		color:#188ae2;
	}
	.end-widget {
		width:100%;
		text-align:right;
	}
	.btn-common {
		width:auto;
		padding:10px 20px;
		background:#fd4967;
		color:#fff;
		border-radius:5px;
		font-size:14px;
		letter-spacing:0.5px;
		transition:all 0.5s ease-in-out 0s;
	}
	.btn-common:hover {
		background:#d32b47;
		color:#fff;
	}
	.btn-common:focus {
		background:#d32b47;
		color:#fff;
		outline:none;
		box-shadow:none;
	}
	.app-aside {
		background: url(<?php echo base_url() ?>assets/css/chart/images/tree-bg.png)no-repeat bottom #fff!important;
	}
	.dashboard-title1 {
		font-size: 20px;
		padding: 0 0 5px 0;
		margin: 0;
		color:#188ae2;
		font-weight: normal;
	}
	.dashboard-sub-title {
		font-size:14px;
		letter-spacing:0.4px;
	}
	.table-bg {
		padding:10px;
	}
	.sorting:after {
		display:none;
	}
	.sorting:before {
		display:none;
	}
	.buttons-excel span {
		display:none;
	}
	.buttons-excel:before {
		content:"CSV Download";
	}
	.buttons-excel {
		background:#188ae2!important;
		color:#fff!important;
		transition:all 0.5s ease-in-out 0s;
	}
	.buttons-excel:hover {
		background:#0e64a7!important;		
	}
	.buttons-excel:focus {
		background:#0e64a7!important;		
		outline:none;
		box-shadow:none;
	}
	.modal {
		background:rgba(0,0,0,0.4);
	}
	.filter-widget textarea {
		width:100%;
		resize:none;
	}
	.filter-widget .col-md-7 {
		width:100%;
	}
	.btn-primary {
		background: #188ae2;
		padding: 8px 15px;
		border: none;
		transition:all 0.5s ease-in-out 0s;
	}
	.btn-primary:hover {
		background:#0b69b1;
	}
	.btn-primary:focus {
		background:#0b69b1;
		outline:none;
		box-shadow:none;
	}
	.btn-default {
		background: #f00;
		color:#fff;
		padding: 8px 15px;
		border: none;
		transition:all 0.5s ease-in-out 0s;
	}
	.btn-default:hover {
		background:#c90a0a;
		color:#fff;
	}
	.btn-default:focus {
		background:#c90a0a;
		color:#fff;
		outline:none;
		box-shadow:none;
	}
	.filter-widget h5 {
		word-break: break-all;
	}	
</style>

<div class="wrap">
	<section class="app-content">
		
		<div class="welcome-area">
			<div class="row align-item-center">
				<div class="col-sm-8">
					<div class="row align-item-center">
						<div class="col-md-2">
							<img src="<?php echo base_url() ?>assets/css/chart/images/email.svg" alt="">
						</div>
						<div class="col-md-10">
							<h2 class="heading-title">
								<strong>Welcome back!</strong> 
								<span><?=$current_user_name?></span>
							</h2>
							<p>
								DFR Candidate Assets Management
							</p>
						</div>
					</div>
				</div>
				<!--<div class="col-sm-4">
					<div class="end-widget">
						<a href="#" class="btn-common">More</a>
					</div>
				</div>-->
			</div>
		</div>
		
		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-md-3">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										Email ID
									</h2>
									<h2 class="dashboard-title1">
										<?=$count_email_required[0]['total_count']?>
									</h2>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										Domain ID
									</h2>
									<h2 class="dashboard-title1">
										<?=$count_domain_required[0]['total_count']?>
									</h2>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										Laptop
									</h2>
									<h2 class="dashboard-title1">
										<?=$count_laptop_required[0]['total_count']?>
									</h2>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										Desktop
									</h2>
									<h2 class="dashboard-title1">
										<?=$count_desktop_required[0]['total_count']?>
									</h2>
								</div>
							</div>
						</div>												
						<div class="col-md-3">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										Keyboard
									</h2>
									<h2 class="dashboard-title1">
										<?=$count_keyboard_hr_required[0]['total_count']?>
									</h2>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										Mouse
									</h2>
									<h2 class="dashboard-title1">
										<?=$count_mouse_required[0]['total_count']?>
									</h2>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										Headset
									</h2>
									<h2 class="dashboard-title1">
										<?=$count_headset_required[0]['total_count']?>
									</h2>
								</div>
							</div>
						</div>						
					</div>
				</div>
			</div>
		</div>	
		
		<div class="common-top">
			<div class="row">
				<div class="col-sm-6">
					<div class="widget">
						<div class="widget-body text-center">
							<canvas id="bar-chart" width="400" height="400"></canvas>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="widget">
						<div class="widget-body text-center">
							<canvas id="bar-doughnut" width="400" height="400"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="widget">
						<div class="table-bg">
							<table id="example" class="table table-bordered table-responsive table-striped">
								<thead>
									<th>Sr</th>
									<th>Date of Request</th>
									<th>Location</th>
									<th>Request By</th>
									<th>Name</th>
									<th>Department</th>
									<th>Role</th>
									<th>Remarks</th>
									<th>Status</th>
									<?php 
									if (get_deptshname()== "IT" || get_role_dir()=="super") {
										echo "<th>Action</th>";
									}
									?>
								</thead>
								<tbody>
									<?php
									$c = 0;
									 foreach ($assets_data as $value) {  $c++; ?>
									<tr>
										<td><?=$c?></td>
										<td><?=$value['raised_date']?></td>
										<td><?=$value['location']?></td>
										<td><?=$value['raised_by']?></td>
										<td><?=$value['can_name']?></td>
										<td><?=$value['department']?></td>
										<td><?=$value['role']?></td>
										<td><?=$value['remarks']?></td>
										<td><?php 
										if ($value['is_comp'] == 1) echo "<span style='color: red'>Pending</span>";
										elseif ($value['is_comp'] == 2) echo "<span style='color: #6f8712'>In-Progress</span>";
										elseif ($value['is_comp'] == 3) echo "<span style='color: green'>Done</span>";
										?></td>
										<?php if (get_deptshname()== "IT" || get_role_dir()=="super") { ?>
										<td>
											<a style="cursor: pointer;" class="edit-btn assets_update_it_team" c_id="<?=$value['dfr_can_id']?>">
												<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
											</a>
										</td>
									<?php } ?>
									</tr>

								<? } ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
    </section>
</div>

<!--------------- Assets Update Model-------------------->
<div class="modal fade modal-design" id="assets_update_it_team_model">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
	  
	<form class="it_team_assets_form_submit" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Assets Details</h4>
      </div>
      <div class="modal-body">
		<div class="filter-widget">
			<input type="hidden" name="c_id" id="c_id" value="">
			<div class="row section_assests_update_it_team" style="margin-left: 10px">			

			</div>		
				
		</div>	
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input  id="verify_submit_btn" type="submit" name="submit" class="btn btn-primary" value="Save">
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>



<script src="<?php echo base_url() ?>assets/css/chart/js/chart.js"></script>
<script>
	var ctxBAR = document.getElementById("bar-chart");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'bar',
		data: {
		labels: ['Email', 'Domain ID', 'Laptop', 'Desktop', 'Keyboard', 'Mouse', 'Headset'],
		datasets: [
	{
	label: "Total Request ",
		data: [<?=$count_email_required[0]['total_count']?>, <?=$count_domain_required[0]['total_count']?>, <?=$count_laptop_required[0]['total_count']?>, <?=$count_desktop_required[0]['total_count']?>, <?=$count_keyboard_hr_required[0]['total_count']?>, <?=$count_mouse_required[0]['total_count']?>, <?=$count_headset_required[0]['total_count']?>],
			 backgroundColor: [
			  'rgba(30, 115, 174, 0.9)',
			  'rgba(243, 118, 43, 0.9)',
			  'rgba(38, 156, 39, 0.9)',
			  'rgba(35, 145, 154, 0.9)',
			  'rgba(203, 138, 143, 0.9)',
			  'rgba(228, 125, 39, 0.9)',
			  'rgba(120, 258, 153, 0.9)'
			  
		],
		borderColor: [
		  'rgb(30, 115, 174)',
		  'rgb(243, 118, 43)',
		  'rgb(38, 156, 39)',
		  'rgb(35, 145, 154)',
		  'rgb(203, 138, 143)',
		  'rgb(228, 125, 39)',
		  'rgb(120, 258, 153)'
		],
			borderWidth: 3
		}
	]
},
	options: {
		legend: { display: false, position: 'right' },
		title: {
		display: true,
		lineHeight: 2,
		text: ""
	},
	tooltips: {
		callbacks: {
			label: function(tooltipItem) {
			return tooltipItem.yLabel + '';
			}
		}
	},
		maintainAspectRatio: false,
			responsive: true,
			scales: {
		xAxes: [{
	}],
	yAxes: [{
		display:true,
		ticks: {
		callback: function(value, index, values) {
		return value + '';
	},
	beginAtZero: true,
		}
	}]
},
	plugins: {
		datalabels: {
			anchor: 'end',
			align: 'top',
			formatter: (value, ctx) => {
			return value + '';
			},
			font: {
			size:9,
			weight: 'bold'
			}
		}
	}
},
});
</script>

<script>
	var ctxBAR = document.getElementById("bar-doughnut");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'doughnut',
		data: {
		labels: [
		<?php foreach($count_details as $tv){ ?>
		<?php if($tv['status_name'] == 1){ echo "'Pending',"; }
		elseif ($tv['status_name'] == 2){ echo "'In-Progress',"; }
		else echo "'Done',"; } ?>
  ],
		datasets: [
	{
	label: "Total",
		data: [<?php foreach($count_details as $tv){ ?>
			  '<?php echo $tv["total_count"]?>',<?php } ?>],
			 backgroundColor: [
			  'rgba(30, 115, 174, 0.9)',
			  'rgba(243, 118, 43, 0.9)',
			  'rgba(38, 156, 39, 0.9)'			 
		],
		borderColor: [
		  'rgb(30, 115, 174)',
		  'rgb(243, 118, 43)',
		  'rgb(38, 156, 39)'		  
		],
			borderWidth: 3
		}
	]
},
	options: {
		legend: { display: false, position: 'right' },
		title: {
		display: true,
		lineHeight: 2,
		text: ""
	},
	tooltips: {
		callbacks: {
			label: function(tooltipItem) {
			return tooltipItem.yLabel + '';
			}
		}
	},
		maintainAspectRatio: false,
			responsive: true,
			scales: {
		xAxes: [{
	}],
	yAxes: [{
		display:true,
		ticks: {
		callback: function(value, index, values) {
		return value + '';
	},
	beginAtZero: true,
		}
	}]
},
	plugins: {
		datalabels: {
			anchor: 'end',
			align: 'top',
			formatter: (value, ctx) => {
			return value + '';
			},
			font: {
			size:9,
			weight: 'bold'
			}
		}
	}
},
});
</script>


<script src="<?php echo base_url() ?>assets/css/data-table-export/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.colVis.min.js"></script>

<script>
	$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ '', 'excel', '', '' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
} );
</script>