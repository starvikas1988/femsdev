<link href="<?=base_url()?>assets/css/search-filter/assets/css/simple-datatables-latest.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />

<script src="<?=base_url()?>assets/css/search-filter/assets/js/all.min.js"></script>
<style>
	.green {
		color:green;
	}
	.red {
		color:red;
	}
	.modal-design .modal-header {
		background:#0808ed;
		color:#fff;
	}
	.modal-design .modal-title {
		color:#fff;
	}
	.modal-design .close {
		background-color: #4650dd;
		outline: none;
		font-weight: 700;
		color: white;
		opacity: 1;
		border-radius: 20px;
		padding: 5px 9px;
		position: absolute;
		top: -14px;
		right: -12px;
	}
	textarea {
		height:120px!important;
	}
	.heading-title {
		padding: 15px 0 5px 0;
	}
	.welcome-area {
		background: rgba(0, 111, 255, 0.10);
	}
	.common-top {
		width:100%;
		margin:10px 0 0 0;
	}
	.submit-btn {
		width:150px;
		padding:10px;
		background:#10c469;
		color:#fff;
		font-size:13px;
		letter-spacing:0.5px;
		transition:all 0.5s ease-in-out 0s;
		border:none;
		border-radius:5px;
		margin: 24px 0 0 0;
	}
	.status_btn2 {
		display: inline-block;
		padding: 2px 15px;
		font-size: 12px;
		font-weight: 400;
		color: #fff !important;
		background: #ffa700 !important;
		border-radius: 30px;
		text-transform: capitalize;
		white-space: nowrap;
		min-width: 70px;
		text-align: center;
	}	
	.submit-btn:hover {
		background:#0b8145;
	}
	.submit-btn:focus {
		background:#0b8145;
		outline:none;
		box-shadow:none;
	}
	.modal {
		background:rgba(0,0,0,0.5)!important;
	}
	th {
		background:#4650dd;
		color:#fff;
	}
	.fresh-design {
		width:100%;
	}
	.fresh-design .modal-dialog {
		width:950px;		
	}
	.repeat-area {
		width:100%;
		margin:0 0 10px 0;
		border-bottom: 1px solid #eee;
    padding: 0 0 10px 0;
	}
	.fresh-design .dropdown-menu {
		width:100%;
	}
	.fresh-design .dropdown-toggle {
		padding: 10px;
		margin: -10px 0 0 0;
		background:transparent!important;
	}
	.fresh-design .dropdown-toggle:focus {
		outline:none!important;
		box-shadow:none!important;
	}
	.fresh-design .form-label {
		margin:12px 0 0 0;
	}
	.popup-title {
		font-size:18px;
		padding:0 0 10px 0;
		margin:0;
		font-weight:bold;
		color:#000;
	}
	select.selectpicker {
		display: block !important;
	}
		.new-view{
			border-radius: 1px!important;
		}
	.new-view .dashboard-title1 ,.new-view .dashboard-title{
		font-size: 16px!important;
	}
	.welcome-area,.card{
		border-radius: 1px!important;
	}
	.new-card{
		margin-bottom: 0.5rem;
	}
</style>
		<div id="layoutSidenav_content">
			<main>
				<div class="container-fluid px-4">
					<h1 class="mt-4 d-flex flex-column text-dark fw-bolder fs-2 mb-4 dash-head">Dashboard</h1>
					<div class="row">
						<div class="col-md-12">
							<div class="welcome-area mb-4">
								<div class="row align-item-center">
									<div class="col-md-8">
										<div class="row align-item-center">
											<div class="col-md-2"> <img src="<?=base_url()?>assets/css/search-filter/assets/img/email.svg" alt=""> </div>
											<div class="col-md-10">
												<h2 class="heading-title">
															<strong>Welcome back!</strong> 
															<span><?=$current_user_name?></span>
														</h2>
												<p style="font-weight: bold;">DFR(Onboarding) IT Assets Management | Recruitment Section</p>
											</div>
										</div>
									</div>
									<div class="col-md-4">

										<?php $download_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].$export_link; ?>

										<a style="float: right;margin-top: 16px;border-radius: 1px;" type="button" href="<?=$download_link?>" class="btn-sm btn btn-primary">Export <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<?php foreach ($assets_mst as $key => $value) { $assets_id = $value['id'];  ?>
						<div class=" col-md-3">
							<div class="card  text-black new-card new-view">
								<div class="card-body text-center">
									<h2 class="dashboard-title">
										<?=$value['name']?>
									</h2>
									<h2 class="dashboard-title1">
										<?php 
										if (isset($assets_count_name[$assets_id])){
											if($assets_count_name[$assets_id] != 0) echo $assets_count_name[$assets_id];
											else echo $assets_count_name[$assets_id];
										}
										else { echo "0"; }
										?>
									</h2> </div>
							</div>
						</div>
					<?php } ?>
					</div>
					<!--<div class="row">
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
					</div>-->
					<div class="common-top">
			<div class="widget">
				<header class="widget-header">
					<h4 class="widget-title">Search</h4>
				</header>
				<hr class="widget-separator">
				<div class="widget-body">					
					<div class="filter-widget">
						<form method="get">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label>Start Date</label>
									<input type="date" name="start_date" value="<?=$start_date?>" class="form-control">
								</div>	
							</div>	
							<div class="col-sm-4">
								<div class="form-group">
									<label>End Date</label>
									<input type="date" name="end_date" value="<?=$end_date?>" class="form-control">
								</div>	
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>Company Brand</label>
									<select name="com_brand" class="form-control">
									<option value="">All</option>
									<?php foreach ($company_brands as $key => $value) { $sel=''; if($com_brand == $value['id']) $sel="selected"; ?>
											<option value="<?php echo $value['id']?>" <?=$sel?>><?php echo $value['name']?></option>
									<?php }?>
									</select>
								</div>	
							</div>	
							<div class="col-sm-4">
								<div class="form-group">
									<label>Department</label>
									<select name="dpt_id" class="form-control">
										<option value="">All</option>
										<?php foreach ($department_data as $key => $value) { $sel=''; if($dpt_id == $value['id']) $sel="selected"; ?>
												<option value="<?php echo $value['id']?>" <?=$sel?>><?php echo $value['shname']?></option>
										<?php }?>
									</select>
								</div>	
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>Location</label>
									<select id="location_id" name="location_id" class="form-control" placeholder="Select Location">
										<option value="">All</option>
										<?php foreach ($location_list as $key => $value) { 
											$sel = "";
											if ($value['abbr'] == $office_id) $sel = "selected";
											?>
												<option value="<?php echo $value['abbr']; ?>" <?php echo $sel; ?>><?php echo $value['office_name'] ?></option>
											<?php } ?>
									</select>
								</div>							
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>Requirement Status</label>
									<select id="location_id" name="req_status" class="form-control" placeholder="Select Status">
											<option value="A" <?php if($req_status == 'A') echo "selected"; ?>>Active</option>
										<option value="CL" <?php if($req_status == 'CL') echo "selected"; ?>>Closed</option>
									</select>
								</div>	
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>Requisition ID</label>
									<input placeholder="For Multiple search using comma seperator" type="text" name="req_id" value="<?=$req_id?>" class="form-control">
								</div>	
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<button type="submit" class="submit-btn">
										<i class="fa fa-search" aria-hidden="true"></i>
										Search
									</button>
								</div>
							</div>							
						</div>
						</form>
						
					</div>
				</div>
			</div>
		</div>
					
					<div class="common-top">
					<div class="card mb-4">
						
						<div class="card-body">
							<table id="datatablesSimple" class="table skt-table table-striped sampleTable">
								<thead>
									<tr>
										<th>Expand</th>
										<th>SL No</th>
										<th>Requisition ID</th>
										<th>Raised Date</th>
										<th>Request By</th>
										<th>Approved By</th>
										<th>Location</th>
										<th>Department</th>
										<th>Company Brand</th>
										<th>Position</th>
										<th>Remarks</th>
										<th>Requirement Status</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>

							<?php 
							$c = 1;
							foreach($dfr_data as $value) {
							$dfr_id = $value['id'];
							?>
								<tbody>
									<tr>
										<td>
											<button type="button" id="dfr_can_it_details" dfr_id="<?=$value['id']?>" class="btn btn-warning btn-xs" data-toggle="collapse" data-target="#dfr_tb<?=$value['id']?>"><i class="fa fa-plus"></i></button>
										</td>
										<td><?=$c?></td>
										<td><?=$value['requisition_id']?></td>
										<td><?=$value['approved_date']?></td>
										<td><?=$value['raised_by']?></td>
										<td><?=$value['approved_by']?></td>
										<td><?=$value['office_name']?></td>
										<td><?=$value['department_name']?></td>
										<td><?=$value['company_brand']?></td>
										<td><?=$value['req_no_position']?></td>
										<td><?=$value['approved_comment']?></td>
										<td><?php
											if($value['requisition_status'] == "A") echo "Active";
											elseif($value['requisition_status'] == "CL") echo "Closed";
											else echo "-";
										?></td>
										<td>
										<?php
											if ($dfr_status_count[$dfr_id] > 0) echo '<label class="btn status_btn pb-1" >Active</label> ';
											else echo '<label class="btn status_btn2 pb-1" >Onboarding</label>';
										?>
										</td>
										<td><button type="button" location="<?=$value['location']?>" dfr_id="<?=$value['id']?>" req_id="<?=$value['requisition_id']?>" class="btn btn-primary btn-xs dfr_assets_details_dashboard"><i class="fa fa-eye"></i></button></td>
									</tr>
									<tr class="collapse" id="dfr_tb<?=$value['id']?>">
										<td colspan="20">
											<table class="table" style="background-color:#FFFFFF;margin-bottom:0px;border:0px !important">
												<tr>													
													<td class="it_assets_reponse_<?=$value['id']?>">
														<table class="table skt-table table-striped table-bordered" cellspacing="0" width="100%" style="background-color:#FFF;margin-bottom:0px;">
															<thead>
																<tr>
																	<th>SL No</th>
																	<th>Name</th>
																	<th>Fusion ID</th>
																	<th>Location</th>
																	<th>Department</th>
																	<th>Role</th>
																	<th>Status</th>
																	<th>Action</th>
																</tr>
															</thead>
															<tbody id="dfr_request_user_<?=$value['id']?>">
															</tbody>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									
								</tbody>
								
							<?php 
								$c++;
								}
							?>

							</table>
						</div>
					</div>
					</div>
				</div>
			</main>

<!-- Modal start Assets Update-->
<div id="model_users_assets" class="modal fade modal-design fresh-design" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" >&times;</button>
        <h4 class="modal-title">Assets Details</h4>
      </div>
      <div class="modal-body">
			<div class="filter-widget">
				<form method="post" action="<?=base_url()?>dfr_it_assets/dfr_user_assets_submit">
					<div class="row user_assets_result">
						<h4>No assets are approve!</h4>
						
					</div>
			</div>			
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default default-btn" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-save" >Save</button>
       </form>
      </div>
    </div>

  </div>
</div>
<!-- modal end -->

<!-- Modal start Assets details-->
<div id="model_users_assets_details" class="modal fade modal-design" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" >&times;</button>
        <h4 class="modal-title">Requisition Details</h4>
      </div>
      <div class="modal-body">
			<div class="filter-widget">
					<!--<div class="row dfr_assets_result">
							<h4>No assets are approve!</h4>
					</div>-->
		<h5 class="req_id_assets"></h5>
		<h5 class="total_can_assets"></h5>				
				<table id="datatablesSimple" class="table skt-table table-striped sampleTable">
				  <thead>
				    <tr>
				      <th>#</th>
				      <th>Asset Name</th>
				      <th>Total Asset Required</th>
					  	<th>Provided</th>
				      <th>In Stock</th>
				    </tr>
				  </thead>
				  <tbody id="dfr_assets_result">
				  </tbody>
				</table>

	</div>
			
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default default-btn" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- modal end -->

			
		</div>
	</div>



<script>
	$(document).on('change','#model_users_assets .select_stat_assets',function(){
		var inf_id = $(this).attr('date-inf');
		var op_value = $(this).val();
		if (op_value == 1) {
			$("#model_users_assets .select_model-"+inf_id).attr('disabled',false);
			$("#model_users_assets .select_comment-"+inf_id).attr('disabled',false);
		}
		else {
			$("#model_users_assets .select_model-"+inf_id).attr('disabled',true);
			$("#model_users_assets .select_comment-"+inf_id).attr('disabled',true);

			$('#model_users_assets .stock_details_serial'+inf_id).html('');
			$('#model_users_assets .stock_details_conf'+inf_id).html('');
			$('#model_users_assets .stock_details_type'+inf_id).html('');

			$("#model_users_assets .select_model-"+inf_id).val("");
			$("#model_users_assets .select_comment-"+inf_id).val();
		}
	});
</script>






	<script src="<?=base_url()?>assets/css/search-filter/assets/js/scripts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<!--
<script src="<?=base_url()?>assets/css/search-filter/assets/js/simple-datatables-latest.js"></script>
<script src="<?=base_url()?>assets/css/search-filter/assets/js/datatables-simple-demo.js"></script>
-->



<script src="<?php echo base_url() ?>assets/css/chart/js/chart.js"></script>
<script>
	var ctxBAR = document.getElementById("bar-chart");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'bar',
		data: {
		labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
		datasets: [
	{
	label: "Visitors",
		data: [12, 19, 3, 5, 2, 3],
			 backgroundColor: [
			  'rgba(30, 115, 174, 0.9)',
			  'rgba(243, 118, 43, 0.9)',
			  'rgba(38, 156, 39, 0.9)',
			  'rgba(30, 115, 174, 0.9)',
			  'rgba(243, 118, 43, 0.9)',
			  'rgba(38, 156, 39, 0.9)',
			  'rgba(243, 118, 43, 0.9)'
		],
		borderColor: [
		  'rgb(30, 115, 174)',
		  'rgb(243, 118, 43)',
		  'rgb(38, 156, 39)',
		  'rgb(30, 115, 174)',
		  'rgb(243, 118, 43)',
		  'rgb(38, 156, 39)',
		  'rgb(243, 118, 43)'
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
    'Red',
    'Blue',
    'Yellow'
  ],
		datasets: [
	{
	label: "Visitors",
		data: [12, 19, 3],
			 backgroundColor: [
			  'rgba(255, 99, 132, 0.9)',
			  'rgba(255, 159, 64, 0.9)',
			  'rgba(255, 205, 86, 0.9)'			 
		],
		borderColor: [
		  'rgb(255, 99, 132)',
		  'rgb(255, 159, 64)',
		  'rgb(255, 205, 86)'		  
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

