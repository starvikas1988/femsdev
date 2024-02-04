<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>


<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>

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
		content:"Download Excel";
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


	/*search option*/

.search-select label {
	display: block;
}

.search-select .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
	width: 100%;
}

.bootstrap-select > .dropdown-toggle {
	height: 40px;
	border-radius: 0px!important;
}

.search-select ul {
	max-height: 200px!important;
}

.search-select .bs-placeholder:hover {
	background: #fff!important;
	box-shadow: none!important;
}

.search-select .dropdown-menu > .active > a,
.search-select .dropdown-menu > .active > a:focus,
.search-select .dropdown-menu > .active > a:hover {
	color: #fff;
	text-decoration: none;
	background-color: #3b5998!important;
	outline: 0;
}

.search-select .dropdown-menu ,.submit-btn{
	border-radius: 1px!important;
}
.filter-widget .form-control{
	padding: 0!important;
	border-radius: 1px!important;
}

.selectize-input{
	border-radius: 1px!important;
}

.filter-widget .form-control:hover {
  border: 1px solid #188ae2;
}
.new-table .col-sm-12{
	overflow-x: auto;
}

</style>

<div class="wrap">
	<section class="app-content">
		

		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								
								<h4 class="widget-title">Assets Assignment report</h4>
							</header>
						</div>						
					</div>
					<hr class="widget-separator">
					
					<div class="filter-widget">
						<div class="widget-body">

							<form method="get">
									<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label>Start date </label>
										<input type="date" name="start_date" type="text" value="<?=$start_date?>" class="form-control" id="start_date">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>End date </label>
										<input type="date" name="end_date" type="text" value="<?=$end_date?>" class="form-control" id="end_date">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group new-select">
										<label>Location</label>
										<select name="office_id" id="office_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
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
									<div class="form-group new-select">
										<label>Department</label>
										<select name="dept_search" id="dept_search" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
											<option value="">All</option>
											<?php foreach ($department_data as $key => $value) { 
											$sel = "";
											if ($value['id'] == $dept_search) $sel = "selected";												?>
												<option <?=$sel?> value="<?php echo $value['id']; ?>"><?php echo $value['shname'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group new-select">
										<label>Select Assets</label>
										<select name="assets_id" id="assets_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
											<option value="">All</option>
											<?php  
												foreach ($assets_list as $value) {
													$sel = "";
													if ($value['id'] == $assets_id) $sel = "selected";
												 ?>
													<option value="<?=$value['id']?>" <?=$sel?>><?=$value['name']?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Assignment Status</label>
										<select name="assign_stat" id="assign_stat" class="select-box assign_stat">
											<option value="">All</option>
											<option value="1" <?php if($assign_stat==1) echo'selected'; ?>>Done</option>
											<option value="3" <?php if($assign_stat==3) echo'selected'; ?>>Pending</option>
											<option value="2" <?php if($assign_stat==2) echo'selected'; ?>>Declined</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>MWP ID </label>
										<input type="text" placeholder="Enter MWP ID" name="mwp_id" type="text" value="<?=$mwp_id?>" class="form-control" id="mwp_id">
									</div>
								</div>
							<div class="col-sm-4 new-select" id="declined_reason_container">
						</div>
								<div class="col-sm-12">
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
		</div>

		<div class="common-top">
			<div class="row ">
				<div class="col-sm-12">
					<div class="widget">
						<div class="table-bg new-table">
							<table id="example" class="table table-bordered table-responsive table-striped">
								<thead>
									<th>Sr</th>
									<th>Name</th>
									<th>Fusion ID</th>
									<th>Location</th>
									<th>Department</th>
									<th>Assets Name</th>
									<th>Serial Number</th>
									<th>Reference ID</th>
									<th>Company Brand</th>
									<th>Provide Date</th>
									<th>Provide By</th>
									<th>Comments</th>
									<th>Assignment Status</th>
									<th>Assignment Type</th>
									<th>Assignment ID</th>
									<th>Declined Reason</th>
									<th>Returned By</th>
									<th>Returned Date</th>
									<th>Assets Status</th>
								</thead>
								<tbody>
									<?php
									$c = 0;
									 foreach ($assets_data as $value) {  $c++; ?>
									<tr>
										<td><?=$c?></td>
										<?php if (($value['inv_user_name']!='' && $value['inv_fusion_id']!='') || ($value['inv_user_name']!=null && $value['inv_fusion_id']!=null)) { ?>

										<td><?=$value['inv_user_name']?></td>
										<td><?=$value['inv_fusion_id']?></td>
										<td><?=$value['inv_location']?></td> 
										<td><?=$value['inv_department']?></td>
										<td><?=$value['assets_name']?></td>
										<td><?=$value['serial_number']?></td>
										<td><?=$value['reference_id']?></td>
										<td><?=$value['company_brand']?></td>
										<td><?=$value['inv_raised_date']?></td>
										<td><?=$value['inv_raised_by']?></td>
										<td><?=$value['inv_comments']?></td>
										<td>
											<?php if($value['inv_is_user_ack']==1) echo "<span style='color:green'>Done</span>";
											elseif($value['inv_is_user_ack']==2) echo "<span style='color:red'>Declined<?span>";
											else echo "<span style='color:red'>Pending</span>";
											?>
										</td>
										<td><?=$value['inv_assign_type']?></td>
										<td><?=$assignment_details[$value['inv_table_id']]?></td>
										<td><?=$value['inv_user_declined_name']?></td>
										<td>
										<?php
											if($value['inv_is_user_ack']==2 && ($value['inv_return_by']!='' || $value['inv_return_by']!=null)) echo "-";
											elseif(($value['inv_return_by']!='' || $value['inv_return_by']!=null)) echo $value['inv_return_by'];
											else echo "";
										?>
										</td>
										<td><?=$value['inv_return_date']?></td>
										<td>
											<?php
											if (($value['inv_return_by']!='' && $value['inv_return_date']!='') || ($value['inv_return_by']!=null && $value['inv_return_date']!=null)) {
											 	echo "<span style='color:red'>Returned</span>";
											 }
											 else echo "<span style='color:green'>Active</span>";
											?>
										</td>

								<?php } else { ?>

										<td><?=$value['non_inv_user_name']?></td>
										<td><?=$value['non_inv_fusion_id']?></td>
										<td><?=$value['non_inv_location']?></td> 
										<td><?=$value['non_inv_department']?></td>
										<td><?=$value['assets_name']?></td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td><?=$value['non_inv_raised_date']?></td>
										<td><?=$value['non_inv_raised_by']?></td>
										<td><?=$value['non_inv_commnets']?></td>
										<td>
											<?php if($value['non_inv_is_user_ack']==1) echo "<span style='color:green'>Done</span>";
											elseif($value['non_inv_is_user_ack']==2) echo "<span style='color:red'>Declined<?span>";
											else echo "<span style='color:red'>Pending</span>";
											?>
										</td>
										<td><?=$value['non_inv_assign_type']?></td>
										<td><?=$assignment_details[$value['non_inv_table_id']]?></td>
										<td><?=$value['non_inv_user_declined_name']?></td>
										<td>
										<?php
											if($value['non_inv_is_user_ack']==2 && ($value['non_inv_return_by']!='' || $value['non_inv_return_by']!=null)) echo "-";
											elseif(($value['non_inv_return_by']!='' || $value['non_inv_return_by']!=null)) echo $value['non_inv_return_by'];
											else echo "";
										?>
											
										</td>
										<td><?=$value['non_inv_return_date']?></td>
										<td>
											<?php
											if (($value['non_inv_return_by']!='' && $value['non_inv_return_date']!='') || ($value['non_inv_return_by']!=null && $value['non_inv_return_date']!=null)) {
											 	echo "<span style='color:red'>Returned</span>";
											 }
											 else echo "<span style='color:green'>Active</span>";
											?>
										</td>

								<?php } ?>
								</tr>
							<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
    </section>
</div>


<script>
	 $(document).ready(function () {
      $('.select-box').selectize({
          sortField: 'text'
      });
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

<script>
var declined_details = `
									<div class="form-group">
										<label>Declined Reason</label>
										<select name="declined_reason" id="declined_reason" class="selectpicker form-control">
											<option value="">All</option>
											<?php  
												foreach ($declined_list as $value) { 
													$sel = "";
													if ($value['id'] == $declined_reason) $sel = "selected";
													?>
													<option value="<?=$value['id']?>" <?=$sel?>><?=$value['name']?></option>
										<?php } ?>
										</select>
									</div>
								`;

if($('#assign_stat').find(":selected").val()==2){ $('#declined_reason_container').html(declined_details); }
else { $('#declined_reason_container').text(' '); }

$(document).on('change','#assign_stat',function(){
	if($(this).val()==2) { $('#declined_reason_container').html(declined_details); }
	else { $('#declined_reason_container').html(' '); }
	$('.selectpicker').selectpicker('refresh');
});

</script>