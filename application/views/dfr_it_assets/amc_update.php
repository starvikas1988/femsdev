<link href="<?=base_url()?>assets/css/search-filter/assets/css/simple-datatables-latest.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/css/search-filter/assets/js/all.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
.container {
	margin-top: 20px;
	font-family: 'Roboto', sans-serif;
	width: 100%;
}

.card {
	position: relative;
	display: flex;
	flex-direction: column;
	min-width: 0;
	word-wrap: break-word;
	background-color: #fff;
	background-clip: border-box;
	border: 1px solid rgba(0, 0, 0, 0.125);
	border-radius: 1px;
	box-shadow: 0 2px 6px 0 rgba(32, 33, 37, .1);
}

.card-header {
	padding: 0.5rem 1rem;
	margin-bottom: 0;
	background-color: rgba(0, 0, 0, 0.03);
	border-bottom: 1px solid rgba(0, 0, 0, 0.125);
	padding: 15px;
	background-color: #3b5998;
	color: #fff;
}

.header {
	font-family: 'Roboto', sans-serif;
	font-weight: 900;
	font-size: 16px;
	text-transform: capitalize;
	letter-spacing: 1px;
}

.card-body {
	flex: 1 1 auto;
	padding: 1rem 1rem;
}

.form-control {
	height: 40px!important;
	border-radius: 0px!important;
	transition: all 0.3s ease;
}

.form-control:focus {
	border-color: #3b5998;
	box-shadow: none!important;
}

.common-space {
	margin-bottom: 10px;
}

textarea {
	width: 100%;
	max-width: 100%;
}

.table tbody th.scope {
	background: #e8ebf8;
	border-bottom: 1px solid #e0e5f6;
}



.btn-save {
	width: 150px;
	border-radius: 1px;
	background: #3b5998;
	color: #fff;
	transition: all 0.3s ease;
	padding: 8px;
}


.btn-save:focus,
.btn-save:hover {
	color: #fff;
	text-decoration: none;
	background: #335192;
	box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .25), 0 3px 10px 5px rgba(0, 0, 0, 0.05) !important;
}

.table > thead > tr > th {
	vertical-align: bottom;
	border-bottom: 1px solid #ddd;
	background: #3b5998;
	color: #fff;
	padding: 15px;
}

.table tbody th.scope {
	background: #3b5998;
	border-bottom: 1px solid #e0e5f6;
	color: #fff;
	text-align: center;
	padding: 15px;
}

.table th,
td {
	text-align: center;
	padding-top: 15px;
}

.margin-Right {
	margin-right: -20px;
}

.paddingTop {
	padding-top: 15px!important;
}

.fa-shield {
	margin-right: 5px;
	font-size: 18px;
}


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

.search-select .dropdown-menu {
	border-radius: 1px!important;
}

.btn-place {
	float: right;
}

.btn-place .btn {
	border-radius: 1px!important;
	color: #3b5998!important;
	font-weight: bold;
}


.btn-place .btn:focus,
.btn-place .btn:hover {
	text-decoration: none;
	background: #fdfafa!important;
	color: #3b5998!important;
	font-weight: bold;
	box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .25), 0 3px 10px 5px rgba(0, 0, 0, 0.05) !important;
}
.new-table .dt-buttons{
	margin: 0!important;
}
.new-table .buttons-excel {
	border-radius: 1px!important;
	padding-top: 10px;
	padding-bottom: 29px;
	background: #3b5998!important;
}

.new-table td {
	padding: 15px!important;
}

.canvas-chart {
	width: 100%;
	display: block;
	box-sizing: border-box;
	height:auto important;
}
.new-modal .modal-content
{
	border-radius: 1px!important;
}
.new-modal .modal-title{
	color: #fff!important;
}
.new-modal .modal-header{
	background: #3b5998!important;
}
.new-modal .modal-header .close{
background-color: #e3e4e7 !important;
color: #3b5998!important;
}
.new-modal .modal-save{
	background: #3b5998;
color: #fff;
padding: 8px;
width: 100px;
border-radius: 1px;
}
.new-modal .modal-save:focus,
.new-modal .modal-save:hover {
	color: #fff;
	text-decoration: none;
	background: #335192;
	box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .25), 0 3px 10px 5px rgba(0, 0, 0, 0.05) !important;
}
.new-modal .modal-footer .btn-default{
	padding: 8px;
width: 100px;
border-radius: 1px;
}
.fa-btn{
  color: #3b5998;
  font-size: 15px;
  border: 1px solid #3b5998;
  border-radius: 1px;
}
.new .btn-sm{
	color: #3b5998!important;
	border-radius: 1px!important;
}
.new-tabs.nav-tabs > li.active > a, .new-tabs .nav-tabs > li.active > a:focus,.new-tabs .nav-tabs > li.active > a:hover {
  color: #fff!important;
  cursor: default;
  background-color: #335192!important;
  border: 1px solid #ddd;
    border-bottom-color: rgb(221, 221, 221);
  border-bottom-color: transparent;
  width: 100%;
  text-align: center;
  border-radius: 1px;
  font-weight: bold;
}

.new-tabs .nav-tabs.nav-justified {
	width: 50%!important;
	border-radius: 1px!important;
	font-weight: bold;
	background:#d0dbe1 ;
color: #3b5998;
transition: all 0.5s ease-in-out 0s;
text-align: center;
}
.parent-button{
	  width: 200px;
  position: relative;
  margin-left: 79px;
}
.parent-button a,.parent-button .btn{
	padding: 10px 20px;
position: absolute;
margin-bottom: 5px;
color: #fff;
border-radius: 1px!important;
z-index: 1;

}

</style>
<div class="container new">
	<div class="new-tabs">
	<ul class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="tab" href="#home"> Assets AMC Update</a></li>
  </ul>
  </div>

   <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
    	<!-- main start -->
      	<div class="common-space">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<canvas id="myChart" class="canvas-chart"></canvas>
							</div>
						</div>
						</div>
						<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<canvas id="myChart1" class="canvas-chart"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	
	<div class="common-space">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-sm-6"> <span class="header view_type_name">View Type: <?php if($amc_view_type == 1) echo "View New AMC Generate"; else echo "View Generated AMC";?></span> </div>
							<div class="col-sm-6">
								<div class="btn-place">
									<a href="<?=base_url()?>it_assets_support/amc_update_dashboard?export=excel_export_amc_update&location_search=<?=$location_search?>" class="btn bn-sm btn-default"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> Export</a>
									<button class="btn bn-sm btn-default" data-toggle="modal" data-target="#myModal"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Import</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
					<form id="assset_stock_amc_search">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group search-select">
									<label for="full_form">View Type:<span style="color: red">*</span> </label>
									<select id="amc_view_type" class="selectpicker" name="amc_view_type" data-show-subtext="true" data-live-search="true">
									<option value="1" <?php if($amc_view_type == '1') echo "selected"; ?>>View New AMC Generate</option>
									<option value="2" <?php if($amc_view_type == '2') echo "selected"; ?> >View Generated AMC</option>
								</select>
								</div>
							</div>	
							<div class="col-sm-3 start_date">
								<div class="form-group">
									<label for="full_form">Start Date</label>
									<input type="date" class="form-control" id="start_date" value="<?php echo @$start_date; ?>" name="start_date">
								</div>
							</div>
							<div class="col-sm-3 end_date">
								<div class="form-group">
									<label for="full_form">End Date</label>
									<input type="date" class="form-control" id="end_date" value="<?php echo @$end_date; ?>" name="end_date"> 
								</div>
							</div>
							<div class="col-sm-3 stock_days">
								<div class="form-group ">
									<label for="full_form">Days: </label>
									<input id="stock_days" type="number" min="1" max="100" oninput="validity.valid||(value='');" class="form-control" value="<?=$stock_days?>" name="stock_days" placeholder="Enter Days">
									</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group search-select">
									<label for="full_form">Location<span style="color: red">*</span></label>
									<select class="selectpicker" name="location_search" data-show-subtext="true" data-live-search="true">
                                    <?php foreach ($location_list as $key => $value) { $sel = "";
                                        if ($value['abbr'] == $location_search) $sel = "selected";?>
                                         <option value="<?php echo $value['abbr']; ?>" <?php echo $sel; ?>><?php echo $value['office_name'] ?></option>
                                        <?php } ?>
                                    </select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group search-select">
									<label for="full_form">Assets</label>
									<select class="selectpicker" name="assets_search" data-show-subtext="true" data-live-search="true">
	                                    <option value="">All</option>
	                                    <?php foreach ($assets_list as $key => $value) { $sel = "";
	                                        if ($value['id'] == $assets_search) $sel = "selected";?>
	                                   <option value="<?php echo $value['id']; ?>" <?php echo $sel; ?>><?php echo $value['name'] ?></option>
	                                    <?php } ?>
                                   </select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group search-select">
									<label for="full_form">Brand</label>
									<select class="selectpicker" name="brand_search" data-show-subtext="true" data-live-search="true">
	                                    <option value="">All</option>
	                                    <?php foreach ($brand_list as $key => $value) { $sel = "";
	                                    if ($value['id'] == $brand_search) $sel = "selected";?>
	                                    <option value="<?php echo $value['id']; ?>" <?php echo $sel; ?>><?php echo $value['name'] ?></option>
	                                    <?php } ?>
                                    </select>
								</div>
							</div>
							<div class="col-sm-3 status_search">
								<div class="form-group search-select">
									<label for="full_form">Assets Status</label>
									<select id="status_search" class="selectpicker" name="status_search" data-show-subtext="true" data-live-search="true">
									<option value="">All</option>
									<option value="1" <?php if($status_search == '1') echo "selected"; ?>>Not Assigned</option>
									<option value="2" <?php if($status_search == '2') echo "selected"; ?>>Assigned</option>
									<option value="5" <?php if($status_search == '5') echo "selected"; ?>>Return</option>
								</select>
								</div>
							</div>
							<div class="col-sm-3 amc_status_search">
								<div class="form-group search-select">
									<label for="full_form">AMC Status<span style="color: red">*</span></label>
									<select id="amc_status_search" class="selectpicker" name="amc_status_search" data-show-subtext="true" data-live-search="true">
									<option value="2" <?php if($amc_status_search == '2') echo "selected"; ?>>On AMC</option>
									<option value="1" <?php if($amc_status_search == '1') echo "selected"; ?> >Expired</option>
									
								</select>
								</div>
							</div>
							<div class="col-sm-3 hod_status_search">
								<div class="form-group search-select">
									<label for="full_form">HOD Approved Status</label>
									<select id="hod_status_search" class="selectpicker" name="hod_status_search" data-show-subtext="true" data-live-search="true">
									<option value="">All</option>
									<option value="1" <?php if($hod_status_search == '1') echo "selected"; ?> >Pending</option>
									<option value="2" <?php if($hod_status_search == '2') echo "selected"; ?>>HOD Approve</option>
								</select>
								</div>
							</div>						
							<div class="col-sm-3">
								<div class="form-group search-select">
									<label for="full_form">Serial Number:</label>
									<input type="text" name="serial_number" class="form-control" placeholder="Enter Serial Number" value='<?php echo $serial_number;?>'>
								</div>
							</div> 
							<div class="col-sm-3">
								<div class="form-group search-select">
									<label for="full_form">Reference ID:</label>
									<input type="text" name="reference_id_search" class="form-control" placeholder="Enter Reference" value='<?php echo $reference_id_search;?>'>
								</div>
							</div>
							<div class="col-sm-12">
								<button class="btn btn-save"><i class="fa fa-paper-plane" aria-hidden="true"></i> Search</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="common-space" id='amc_portion'>
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-body new-table new-dash">
					<?php
			if($amc_view_type=='1'){?>		
			<div class="parent-button">
				
				<button type="button" class="btn btn-success btn-action " title="Active"  id='hod' onclick="change_sts_active('active')" style="display:none;"> Send To HOD</button>

            </div> 
			<?php }
			if($is_hod_user === true && $amc_view_type=='2'){?>
			<div class="row" style="padding: 10px 10px 0 10px;  left: 82px; top:6px;color: #fff;position: absolute;z-index: 1;">
							<div class="col-sm-2">
								<div><a href="javascript:void(0)" class="btn btn-success btn-action " title="approve"  id='amc' onclick="change_approve_active('active')" style="display:none; padding: 10px 20px;  width: 100px;margin-right:450px;border-radius: 1px;margin-left:123px;"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approve</a> </div>	
							</div>

							<div class="col-sm-2">
								<a href="javascript:void(0)" class="btn btn-danger btn-action " title="Reject"  id='amc1' onclick="change_reject_active('active')" style="display:none;padding: 10px 20px;color: #fff;border-radius: 1px;margin-left: 86px; width: 100%;"><i class="fa fa-trash" aria-hidden="true"></i> Reject</a>
							</div>

						</div>
						<?php }?>
						<table class="table table-striped " id="datatablesSimple">
							<thead>
							    <th><input type="checkbox" name="all" id="all_chk" class="all_chk"></th>
							     <th>SL No</th>
								<th>Serial No</th>
								<th>Referance ID</th>
								<th>Location</th>
								<th>Assets Name</th>
								<th>Under Validaty </th>
								<th>Expired On  </th>
								<th>Current Status </th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php 
								$i=1;
								if(count($result_data) > 0){
								foreach($result_data as $row) {
									//echo $row['am_status'];
								$datetime1 = date_create(date('Y-m-d'));	
								$datetime2 = date_create($row['valid_thru']);
								
								$interval = date_diff($datetime1, $datetime2);
								$dtdiff = $interval->format('%R%m month %d days');	
								$first_character = mb_substr($dtdiff, 0, 1);
								$second_character = substr($dtdiff, 1);
								if($row['am_status']=='1')
								{
									$label = '<span class="label label-primary">Pending</span>';
								}
								if($row['am_status']=='2')
								{
									$label = '<span class="label label-success">Hod Approved</span>';
								}
								if($row['am_status']=='3')
								{
									$label = '<span class="label label-warning">Reject</span>';
								}
								if($row['am_status']=='4')
								{
									$label = '<span class="label label-danger">Cancel</span>';
								}
								if($row['am_status']=='')
								{
									$label = '<span class="label label-default">Not send For Approval</span>';
								}
								?>
								<tr>
								<td>
									<?php if((in_array($row['am_status'], array('3','4','5')) || $row['am_status'] == NULL) && $amc_view_type == '1') { ?>
										<input type="checkbox" name="record1" class ='all_chk' value="<?php echo $row['id'];?>" >
								<?php } elseif($row['am_status']==1 && $amc_view_type == '2') { ?>
									<input type="checkbox" name="record1" class ='all_chk' value="<?php echo $row['amc_id'];?>" >
									<?php }?>
							</td>
									<td><?php echo $i++; ?></td>
									<td><?php echo $row['serial_number']; ?></td>
									<td><?php echo $row['reference_id']; ?></td>
									<td><?php echo $row['office_name']; ?></td>
									<td><?php echo $row['asset_name']; ?></td>
									<td><?php echo ($row['under_validity'] == '1') ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>'; ; ?></td>
									<td><?php echo ($first_character == '-') ? '<span class="label label-danger">N/A</span>' : '<span class="label label-primary">'.$second_character.'</span>'; ?></td>
									<td><?php echo ($first_character == '-') ? '<span class="label label-danger">Expired</span>' : '<span class="label label-success">ON AMC</span>'; ?></td>
									<td><?php echo @$label ; ?>
									</td>
								</tr>
								<?php }}?>
							</tbody>
							<tfoot></tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>



<!-- main end -->
    </div>

</div>
</div>



      
        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
 --><script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
<!--start data table with export button-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table/css/buttons.bootstrap.min.css" />
<script src="<?php echo base_url() ?>assets/css/data-table/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {
	var table = $('#datatablesSimple').DataTable({
		lengthChange: false,
		buttons: [{
			extend: 'excel',
			split: ['', ''],
		}]
	});
	table.buttons().container().appendTo('#datatablesSimple_wrapper .col-sm-6:eq(0)');
});
</script>
<!--end data table with export button-->
<script>

var xValues = [<?php $comma=''; foreach ($assets_list as $key => $value) 
                        { echo $comma.'"'.$value['name'].'"';$comma=',';}?>];
var yValues = [<?php $comma=''; foreach ($amc_count as $key => $value) 
					{ echo $comma.$value;$comma=',';}?>];
var barColors = ["#3b5998", "#536ca1", "#1a397b", "#09399e96", "#50699f"];
new Chart("myChart", {
	type: "bar",
	data: {
		labels: xValues,
		datasets: [{
			backgroundColor: barColors,
			data: yValues,
			borderWidth: 2,
			borderSkipped: false,
			borderRadius: 0,
			barThickness: 20,
			responsive:true,
			maintainAspectRatio: false

		}]
	},
	options: {
		legend: {
			display: false
		},

		title: {
			display: true,
			text: "ON AMC (Under 60 Days) - Current Date"
		}
	}
});
</script>
</script>
<!--end data table with export button-->
<script>
var xValues = [<?php $comma=''; foreach ($assets_list as $key => $value) 
                        { echo $comma.'"'.$value['name'].'"';$comma=',';}?>];
var yValues = [<?php $comma=''; foreach ($amc_count1 as $key => $value) 
					{ echo $comma.$value;$comma=',';}?>];
var barColors = ["#3b5998", "#536ca1", "#1a397b", "#09399e96", "#50699f"];
new Chart("myChart1", {
	type: "bar",
	data: {
		labels: xValues,
		datasets: [{
			backgroundColor: barColors,
			data: yValues,
			borderWidth: 2,
			borderSkipped: false,
			borderRadius: 0,
			barThickness: 20,
			responsive:true,
			maintainAspectRatio: false

		}]
	},
	options: {
		legend: {
			display: false
		},
		title: {
			display: true,
			text: "Expired - Current Date"
		}
	}
});
</script>
	
<script>
$(document).ready(function() {
	var table = $('#datatablesSimple1').DataTable({
		lengthChange: false,
		buttons: [{
			extend: 'excel',
			split: ['', ''],
		}]
	});
	table.buttons().container().appendTo('#datatablesSimple1_wrapper .col-sm-6:eq(0)');
});
</script>
<!--end data table with export button-->

<script>
let amc_view_type_id = <?=$amc_view_type?>

if (amc_view_type_id == '1') {
        $("#start_date").prop("disabled",true);
       	$(".start_date").attr({style: "display: none",});

       	$("#end_date").prop("disabled",true);
       	$(".end_date").attr({style: "display: none",});

       	$("#hod_status_search").prop("disabled",true);
       	$(".hod_status_search").attr({style: "display: none",});

       	$("#stock_days").prop("disabled",false);
       	$(".stock_days").attr({style: "display: block",});

       	$("#amc_status_search").prop("disabled",false);
       	$(".amc_status_search").attr({style: "display: block",}); 

       	$(".view_type_name").text("View Type: View New AMC Generate");
}
else {
        $("#start_date").prop("disabled",false);
       	$(".start_date").attr({style: "display: block",});

       	$("#end_date").prop("disabled",false);
       	$(".end_date").attr({style: "display: block",});

       	$("#hod_status_search").removeAttr("disabled");
       	$(".hod_status_search").attr({style: "display: block",});

       	$("#stock_days").prop("disabled",true);
       	$(".stock_days").attr({style: "display: none",});

       	$("#amc_status_search").prop("disabled",true);
       	$(".amc_status_search").attr({style: "display: none",});

       	$(".view_type_name").text("View Type: View Generated AMC"); 
}

$(document).on('change','#assset_stock_amc_search #amc_view_type',function(){
	let view_type = $(this).val();
	if (view_type == 1) {
        $("#start_date").prop("disabled",true);
       	$(".start_date").attr({style: "display: none",});

       	$("#end_date").prop("disabled",true);
       	$(".end_date").attr({style: "display: none",});

       	$("#hod_status_search").prop("disabled",true);
       	$(".hod_status_search").attr({style: "display: none",});

       	$("#stock_days").prop("disabled",false);
       	$(".stock_days").attr({style: "display: block",});

       	$("#amc_status_search").prop("disabled",false);
       	$(".amc_status_search").attr({style: "display: block",}); 

       	$(".view_type_name").text("View Type: View New AMC Generate"); 
       	$('.selectpicker').selectpicker('refresh');	
	}
	else {
        $("#start_date").prop("disabled",false);
       	$(".start_date").attr({style: "display: block",});

       	$("#end_date").prop("disabled",false);
       	$(".end_date").attr({style: "display: block",});

       	$("#hod_status_search").removeAttr("disabled");
       	$(".hod_status_search").attr({style: "display: block",});

       	$("#stock_days").prop("disabled",true);
       	$(".stock_days").attr({style: "display: none",});

       	$("#amc_status_search").prop("disabled",true);
       	$(".amc_status_search").attr({style: "display: none",});

       	$(".view_type_name").text("View Type: View Generated AMC");    
       	$('.selectpicker').selectpicker('refresh');	
	}
});
</script>