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
</style>

<div class="wrap">
	<section class="app-content">
		

		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								
								<h4 class="widget-title">Search</h4>
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
										<input name="start_date" type="text" value="<?=$start_date?>" class="form-control date_ijp_h" id="start_date">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>End date </label>
										<input name="end_date" type="text" value="<?=$end_date?>" class="form-control date_ijp_h" id="end_date">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Location</label>
										<select name="ofc_id" id="ofc_id" class="select-box" placeholder="Select Location">
											<option value="">Select a Location</option>
										<?php foreach ($location_list as $key => $value) { 
											$sel = "";
											if ($value['abbr'] == $office_id) $sel = "selected";
											if (get_global_access() == 1) { ?> <option value="All">All</option> <?php } ?>
											?>
												<option value="<?php echo $value['abbr']; ?>" <?php echo $sel; ?>><?php echo $value['office_name'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Status</label>
										<select name="status" id="status" class="form-control" placeholder="Select status">
											<option value="" selected>Select a Status</option>
											<option value="1" <?php if ($status == 1) echo "selected" ?>>Pending</option>
											<option value="2" <?php if ($status == 2) echo "selected" ?>>In-progress</option>
											<option value="3" <?php if ($status == 3) echo "selected" ?>>Done</option>
										</select>
									</div>
								</div>								
								<div class="col-sm-4">
									<div class="form-group">
										<label>Department</label>
										<select name="dept_search" id="dept_search" class="select-box" placeholder="Select Department">
											<option value="">Select a Department</option>
											<?php foreach ($department_data as $key => $value) { 
											$sel = "";
											if ($value['id'] == $dept_search) $sel = "selected";												?>
												<option <?=$sel?> value="<?php echo $value['id']; ?>"><?php echo $value['shname'] ?></option>
											<?php } ?>
										</select>
									</div>
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
									<th>Update By</th>
									<th>Status</th>
									<?php 
									// if (get_deptshname()== "IT" || get_role_dir()=="super") {
									// 	echo "<th>Action</th>";
									// }
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
										<td><?=$value['name_update_by']?></td>
										<td><?php 
										if ($value['is_comp'] == 1) echo "<span style='color: red'>Pending</span>";
										elseif ($value['is_comp'] == 2) echo "<span style='color: #6f8712'>In-Progress</span>";
										elseif ($value['is_comp'] == 3) echo "<span style='color: green'>Done</span>";
										?></td>
										<?php if (get_deptshname()== "IT" || get_role_dir()=="super") { ?>
										<!--<td>
											<a style="cursor: pointer;" class="edit-btn assets_update_it_team" c_id="<?=$value['dfr_can_id']?>">
												<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
											</a>
										</td>-->
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
<div class="modal fade modal-design" id="assets_update_it_team_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
	  
	<form class="it_team_assets_form_submit" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Assets Details</h4>
      </div>
      <div class="modal-body" >
      	<input type="hidden" name="c_id" id="c_id" value="">
      	<div class="row section_assests_update_it_team" style="margin-left: 10px">			

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