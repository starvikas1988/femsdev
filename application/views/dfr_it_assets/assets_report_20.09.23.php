<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>


<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table-export/css/dataTables.bootstrap.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table-export/css/buttons.bootstrap.min.css"/>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;1,900&display=swap');

body{
 font-family: 'Roboto', sans-serif!important;
}

	.table > thead > tr > th {
	  vertical-align: top!important;
	}
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
.widget th{
font-size: 12px!important;
text-align:center!important;
font-weight: 500!important;

}

table.dataTable thead .sorting::after, table.dataTable thead .sorting_asc::after, table.dataTable thead .sorting_desc::after, table.dataTable thead .sorting_asc_disabled::after, table.dataTable thead .sorting_desc_disabled::after {
  display: none !important;
}

.widget td {
  text-align: center !important;
}

table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting {
  padding-right: 30px !important;
  padding-left: 30px !important;
}



	label {
		/*padding: .7em .6em;*/
		font-weight: 500!important;
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
									<?php $label_color = 'style="color: #10c469"'; ?>
								<h4 class="widget-title">Assets report</h4>
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
										<?php if($start_date!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Start date" <?=$label_sel?>>Start date </label>
										<input type="date" name="start_date" type="text" value="<?=$start_date?>" class="form-control selected_check" id="start_date">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($end_date!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="End date" <?=$label_sel?>>End date </label>
										<input type="date" name="end_date" type="text" value="<?=$end_date?>" class="form-control selected_check" id="end_date">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($office_id!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Location" <?=$label_sel?>>Location</label>
										<select name="office_id" id="office_id" class="select-box selected_check">
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
										<?php if($phy_location!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Physical Location" <?=$label_sel?>>Physical Location</label>
										<select name="physical_location" id="physical_location" class="select-box selected_check">
											<option value="">All</option>
											<?php  
												foreach ($physical_location as $value) {
													$sel = "";
													if ($value['id'] == $phy_location) $sel = "selected";
												 ?>
													<option value="<?=$value['id']?>" <?=$sel?>><?=$value['location_name']?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($assets_id!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Assets" <?=$label_sel?>>Assets</label>
										<select name="assets_id" id="assets_id" class="select-box selected_check">
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
										<?php if($brand_id!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Brand" <?=$label_sel?>>Brand</label>
										<select name="brand_id" id="brand_id" class="select-box selected_check">
											<option value="">All</option>
											<?php  
												foreach ($brand_list as $value) {
													$sel = "";
													if ($value['id'] == $brand_id) $sel = "selected";
												 ?>
													<option value="<?=$value['id']?>" <?=$sel?>><?=$value['name']?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($vendor_id!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Vendor" <?=$label_sel?>>Vendor</label>
										<select name="vendor_id" id="vendor_id" class="select-box selected_check">
											<option value="">All</option>
											<?php  
												foreach ($vendor_list as $value) {
													$sel = "";
													if ($value['id'] == $vendor_id) $sel = "selected";
												 ?>
													<option value="<?=$value['id']?>" <?=$sel?>><?=$value['vnd_name']?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($ram_size!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="RAM" <?=$label_sel?>>RAM</label>
										<select name="ram_size" id="ram_size" class="select-box selected_check">
											<option value="">All</option>
											<?php  
												foreach ($ram_list as $value) {
													$sel = "";
													if ($value['id'] == $ram_size) $sel = "selected";
												 ?>
													<option value="<?=$value['id']?>" <?=$sel?>><?=$value['size']." GB"?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($com_brand!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Company Brand" <?=$label_sel?>>Company Brand</label>
										<select name="com_brand" id="com_brand" class="select-box selected_check">
											<option value="">All</option>
											<?php  
												foreach ($company_brand as $value) {
													$sel = "";
													if ($value['id'] == $com_brand) $sel = "selected";
												 ?>
													<option value="<?=$value['id']?>" <?=$sel?>><?=$value['name']?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($own_rental!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Own/Rental/Client" <?=$label_sel?>>Own/Rental/Client</label>
										<select name="own_rental" id="own_rental" class="select-box assign_stat selected_check">
											<option value="">All</option>
											<option value="1" <?php if($own_rental==1) echo'selected'; ?>>Own</option>
											<option value="2" <?php if($own_rental==2) echo'selected'; ?>>Rental</option>
											<option value="3" <?php if($own_rental==3) echo'selected'; ?>>Client</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($under_validity!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Under Validity" <?=$label_sel?>>Under Validity</label>
										<select name="under_validity" id="under_validity" class="select-box assign_stat selected_check">
											<option value="">All</option>
											<option value="1" <?php if($under_validity==1) echo'selected'; ?>>Yes</option>
											<option value="2" <?php if($under_validity==2) echo'selected'; ?>>No</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($purhcase_type!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Purchase Type" <?=$label_sel?>>Purchase Type</label>
										<select name="purhcase_type" id="purhcase_type" class="select-box assign_stat selected_check">
											<option value="">All</option>
											<option value="2" <?php if($purhcase_type==2) echo'selected'; ?>>Capex</option>
											<option value="1" <?php if($purhcase_type==1) echo'selected'; ?>>Opex</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<?php if($status_search!="") $label_sel = $label_color; else $label_sel = ""; ?>
										<label class="check_lable" content_text="Status" <?=$label_sel?>>Status</label>
										<select name="status_search" id="status_search" class="select-box assign_stat selected_check">
											<option value="">All</option>
                        <option value="1" <?php if($status_search == '1') echo "selected"; ?>>Un-Assigned/Released</option>
                      <option value="2" <?php if($status_search == '2') echo "selected"; ?>>Assigned</option>
                      <option value="8" <?php if($status_search == '8') echo "selected"; ?>>Live</option>
                      <option value="3" <?php if($status_search == '3') echo "selected"; ?>>Scrap</option>
                      <option value="4" <?php if($status_search == '4') echo "selected"; ?>>Defect</option>
                      <option value="5" <?php if($status_search == '5') echo "selected"; ?>>Return(Un-Assigned/Released)</option>
                      <option value="6" <?php if($status_search == '6') echo "selected"; ?>>Stock</option>
                      <option value="7" <?php if($status_search == '7') echo "selected"; ?>>Misplaced/Lost</option>
                      <option value="9" <?php if($status_search == '9') echo "selected"; ?>>In-Stock(Check Overall Stock)</option>
										</select>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<button style="width: 150px;" type="submit" class="submit-btn">
											<i class="fa fa-search" aria-hidden="true"></i>
											Search
										</button>
										<span style="padding: 10px;font-weight: bold;font-size: 17px;"> OR </span>
										<input name="submit_download" value="Download Excel" style="width: 129px;" type="submit" class="submit-btn">
	
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
									<th>Assets Name</th>
									<th>Serial Number</th>
									<th>Reference ID</th>
									<th>Current Location</th>
									<th>Physical Location</th>
									<th>Raised By</th>
									<th>Raised Date</th>
									<th>Jitbit ID (Floor Assign)</th>
									<th>Assigned By (Floor Assign)</th>
									<th>Assigned Date (Floor Assign)</th>
									<th>Department (Floor Assign)</th>
									<th>Client (Floor Assign)</th>
									<th>Process (Floor Assign)</th>
									<th>Assigned Comments (Floor Assign)</th>
									<th>Brand</th>
									<th>Model Number</th>
									<th>PO Number</th>
									<th>Purchase Type</th>
									<th>Processor</th>
									<th>RAM</th>
									<th>Storage Type</th>
									<th>Storage Size</th>
									<th>Own/rental/client</th>
									<th>Date Purchase</th>
									<th>Vendor Name</th>
									<th>Under Validity</th>
									<th>Valid thru</th>
									<th>OS Name</th>
									<th>Conditons</th>
									<th>Company Brand</th>
									<th>Remarks/comments</th>
									<th>Status comments</th>
									<th>Type</th>
									<th>Last Update By</th>
									<th>Assigned To (User Assign)</th>
									<th>Assigned By (User Assign)</th>
									<th>Department (User Assign)</th>
									<th>Client (User Assign)</th>
									<th>Process (User Assign)</th>
									<th>Status</th>
								</thead>
								<tbody>
									<?php
									$c = 0; $stat="";
									 foreach ($assets_data as $value) {  $c++;

                      if($process_data[$value['id']] != null){
                        $client_name = $process_data[$value['id']][0]['client_name'];
                        $process_name = $process_data[$value['id']][0]['process_name'];
                        $department_name = $process_data[$value['id']][0]['department_name'];
                        $assigned_by = $process_data[$value['id']][0]['assigned_by_floor'];
                        $assigned_date = $process_data[$value['id']][0]['assign_date'];
                        $assign_comments = $process_data[$value['id']][0]['comments'];
                        $jitbit_id = $process_data[$value['id']][0]['jitbit_id'];
                      }
                      else {
                        $client_name= "-";
                        $process_name= "-";
                        $department_name= "-";
                        $assigned_by= "-";
                        $assigned_date= "-";
                        $assign_comments= "-";
                        $jitbit_id = "-";
                      }

                      if($value['status'] == 1) $stat = "<label class='label label-primary'>Un-Assigned/Released</label>";
                      if($value['status'] == 2) $stat = "<label class='label label-success'>Assigned</label>";
                      if($value['status'] == 3) $stat = "<label class='label label-default'>Scrap</label>";
                      if($value['status'] == 4) $stat = "<label class='label label-danger'>Defect</label>";
                      if($value['status'] == 5) $stat = "<label class='label label-info'>Return(Un-Assigned/Released)</label>";
                      if($value['status'] == 6) $stat = "<label class='label label-default'>Stock</label>";
                      if($value['status'] == 7) $stat = "<label class='label label-default'>Misplaced / Lost</label>";
                      if($value['status'] == 8) $stat = "<label class='label label-info'>Live</label>";
									 	?>
									<tr>
										<td><?=$c?></td>
										<td><?=$value['assets_name']?></td>
										<td><?=$value['serial_number']?></td>
										<td><?=$value['reference_id']?></td>
										<td><?=$value['location']?></td>
										<td><?=$value['phy_location']?></td>
										<td><?=$value['raised_by_name']?></td>
										<td><?=$value['raised_date']?></td>

										<td><?=$jitbit_id?></td>
										<td><?=$assigned_by?></td>
										<td><?=$assigned_date?></td>
										<td><?=$department_name=="" ? "All" : $department_name?></td>
										<td><?=$client_name=="" ? "All" : $client_name?></td>
										<td><?=$process_name=="" ? "All" : $process_name?></td>
										<td><?=$assign_comments=="" ? " " : $assign_comments?></td>

										<td><?=$value['brand_name']?></td>
										<td><?=$value['model_number']?></td>
										<td><?=$value['po_number']?></td>
										<td><?php
											if($value['purchase_type']=='1') echo "Opex";
											else echo "Capex";
										?></td>
										<td><?=$value['processor_name']?></td>
										<td><?=$value['ram_size']?></td>
										<td><?php
											if($value['storage_device_type']=='1') echo "SSD";
											else echo "HDD";
										?></td>
										<td><?=$value['storage_size']?></td>
										<td><?php
											if($value['own_rental']=='1') echo "Own";
											elseif($value['own_rental']=='2') echo "Rental";
											elseif($value['own_rental']=='3') echo "Client";
											else echo "-";
										?></td>
										<td><?=$value['data_purchase']?></td>
										<td><?=$value['vendor_name']?></td>
										<td><?php
											if($value['under_validity']=='1') echo "Yes";
											else echo "No";
										?></td>
										<td><?=$value['valid_thru']?></td>
										<td><?=$value['os_name']?></td>
										<td><?=$value['conditions']?></td>
										<td><?=$value['brand_company']?></td>
										<td><?=$value['reamrks']?></td>
										<td><?=$value['comments_status']?></td>
										<td><?php
											if($value['type']=='1') echo "New";
											else echo "Existing";
										?></td>
										<td><?=$value['update_by_name']?></td>
										<td><?=$value['assigned_to']?></td>
										<td><?=$value['assigned_by']?></td>
										<td><?=$value['user_department']?></td>
										<td><?=$value['user_client']?></td>
										<td><?=$value['user_process']?></td>
										<td><?=$stat?></td>
								</tr>
							<?php $c++; } ?>
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
        buttons: [ '', '', '', '' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
} );
</script>

<script>
$(document).on('change','.selected_check',function(){
	value = $(this).val();
	if (value=="") {
		$(this).closest('div').find('.check_lable').css("color", "#67686a");
		let label_text = $(this).closest('div').find('.check_lable').attr('content_text');
		$(this).closest('div').find('.check_lable').html("");
		$(this).closest('div').find('.check_lable').html(label_text); 
	}
	else {
		let label_text = $(this).closest('div').find('.check_lable').attr('content_text');
		$(this).closest('div').find('.check_lable').html("");
		$(this).closest('div').find('.check_lable').html('<span style="color: #10c469">'+label_text+'</span>'); 
	}

});
</script>