<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>

<style>
	.table>thead>tr>th,
	.table>thead>tr>td,
	.table>tbody>tr>th,
	.table>tbody>tr>td,
	.table>tfoot>tr>th,
	.table>tfoot>tr>td {
		padding: 2px;
		text-align: center;
	}

	#show {
		margin-top: 5px;
	}

	td {
		font-size: 10px;
	}

	#default-datatable th {
		font-size: 11px;
	}

	#default-datatable th {
		font-size: 11px;
	}

	.table>thead>tr>th,
	.table>thead>tr>td,
	.table>tbody>tr>th,
	.table>tbody>tr>td,
	.table>tfoot>tr>th,
	.table>tfoot>tr>td {
		padding: 3px;
	}

	.largeModal .modal-dialog {
		width: 800px;
	}
	/*start multiselect css here*/
	.common-top {
		width:100%;
		margin:10px 0 0 0;
	}
	.multiselect {
		width:100%;
		text-align:left;
	}	
	.checkbox input[type="checkbox"] {
		opacity:1;
	}
	.submit-btn {
		width:130px;
	}
	.pagination {
		display:flex;
		justify-content: end;
	}
	/*end multiselect css here*/
	.btn-new{
		width:150px;
		padding: 10px;
	}
</style>

<div class="wrap">
	<section class="app-content">

		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">Filter <?php echo !empty($pageName) ? $pageName : ''; ?> List</h4>
			</header>
			<hr class="widget-separator">
			<div class="widget-body ">
				<?php
				//if(get_global_access()==true){
				?>

				<form method="GET">
					<div class="row">

						<div class="col-md-4">
							<div class="form-group filter-widget">
								<select class="form-control" id="office_id" name="office_id[]" autocomplete="off1" placeholder="Select Assets" multiple>
									<!-- <option value="">Select</option> -->
									<!-- $selected = ""; -->
									<?php foreach ($locationList as $token) {
										$selected = '';
										if(in_array($token['abbr'],$officeID)) {
											$selected = 'selected';
										} ?>
										<option value="<?php echo $token['abbr']; ?>" <?php echo $selected; ?>><?php echo $token['office_name']; ?></option>
									<?php
									} ?>
								</select>
							</div>
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<button class="btn btn-primary btn-new"><i class="fa fa-search"></i> Search</button>
							</div>
						</div>

					</div>
				</form>
				<?php
				//}
				?>
			</div>
		</div>


		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">ID Card <?php echo !empty($pageName) ? $pageName : ''; ?> List</h4>

				<div class='row'>

					<div class="text-center col-md-2" id="checkSelection" style="display:none;float:right;">
						<?php if ($currentPage == 'pending' || $currentPage == 'approved' || $currentPage == 'printing' || $currentPage == 'distribute' || $currentPage == 'handover') {
							if ($currentPage == 'pending') {
								$btype = 2;
							} elseif ($currentPage == 'approved') {
								$btype = 3;
							} elseif ($currentPage == 'printing') {
								$btype = 4;
							} elseif ($currentPage == 'distribute') {
								$btype = 5;
							} elseif ($currentPage == 'handover') {
								$btype = 6;
							} ?>
							<button type="button" style="padding: 5px 10px; float:right; background-color:<?php echo $cardStatus['T']['color']; ?>" sdata="" udata="" stdata="" btype="<?php echo $btype; ?>" class="btn btn-warnings text-white actionStatusButtonBulk">
								<i class="fa fa-print"></i><?php echo $btype == 2 ? ' Bulk Approve / Reject' : ' Bulk Move'; ?></button>
						<?php
						} ?>
					</div>

					<?php if (!empty($main)) {
						if (!empty($download_link_pro)) { ?>
							<div style='float:right; margin-top:0px;' class="col-md-2">
								<a id="download_pro" href='<?php echo $download_link_pro; ?>'><span style="padding:10px; float:right;" class="label label-success">Export Report</span></a>
							</div>
					<?php }
					} ?>

				</div>

			</header>

			<hr class="widget-separator">
			<div class="widget-body">

				<div class="table-responsive">
					<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%" style="margin-bottom:0px;">
						<thead>
							<tr class="bg-info">
								<?php if (($currentPage == 'pending' && get_dept_folder() == 'hr' && is_hr_permission_id_card() == true) || $currentPage == 'approved' || $currentPage == 'printing' || $currentPage == 'distribute' || $currentPage == 'handover') { ?>
									<th>
										<input style="height: 15px;" type="checkbox" name="employee_id_checkbox_all" id="employee_id_checkbox_all" value=""> &nbsp;&nbsp;
									</th>
								<?php } ?>
								<th>
									#
								</th>
								<th>Fusion ID</th>
								<th>Employee Status</th>
								<th>Name</th>
								<th>Department</th>
								<th>Role</th>
								<th>Image</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $counter = 0;
							foreach ($main as $value) {
								++$counter;
								$dataLogsVal = $value['id'] . '#' . $value['user_id'] . '#' . $value['status']; ?>

								<tr>
									<?php if (($currentPage == 'pending' && get_dept_folder() == 'hr' && is_hr_permission_id_card() == true) || $currentPage == 'approved' || $currentPage == 'printing' || $currentPage == 'distribute' || $currentPage == 'handover') { ?>
										<td>
											<input type="checkbox"  name="employee_id_checkbox[]" value="<?php echo $value['id']; ?>"> &nbsp;&nbsp;
										</td>
									<?php } ?>
									<td>
										<?php echo $counter; ?>
									</td>
									<td><?php echo $value['fusion_id']; ?></td>
									<td>
										<?php 
										$_status=$value['emp_status'];
										if($_status==1) echo '<span class="label label-info">Active</span>'; 
										else if($_status==0) echo '<span class="label label-danger">Terms</span>';
										else if($_status==2) echo '<span class="label label-warning">Pre-Terms</span>';
										else if($_status==3) echo '<span class="label label-warning">Suspended</span>'; 
										else if($_status==4) echo '<span class="label label-primary">New Users</span>';
										else if($_status==5) echo '<span class="label label-warning">Bench Paid</span>';
										else if($_status==6) echo '<span class="label label-warning">Bench Unpaid</span>'; 
										else if($_status==7) echo '<span class="label label-info">Furlough</span>';
										else echo '<span class="label label-default">Deactive</span>';
										
										?>
									</td>
									<td><?php echo $value['employee_name']; ?></td>
									<td><?php echo $value['department']; ?></td>
									<td><?php echo $value['designation']; ?></td>
									<td>
										<a href="" onclick="window.open('<?php echo base_url() . $value['image_link']; ?>','targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1090px, height=550px, top=25px left=120px'); return false;"><img src='<?php echo base_url() . '/' . $value['image_link']; ?>' style="height:50px;width:50x;"></a>
									</td>
									<td>
										<span style="color:<?php echo $cardStatus[$value['status']]['color']; ?>"><b><?php echo $cardStatus[$value['status']]['name']; ?></b></span>
									</td>
									<td>
										<?php if (get_dept_folder() == 'hr' && is_hr_permission_id_card() == true) { ?>
											<?php if ($currentPage == 'pending' || ($value['status'] == 'P' && $currentPage == 'all')) { ?>
												<button type="button" class="btn btn-success actionStatusButton" sdata="<?php echo $dataLogsVal; ?>" btype="2"><i class="fa fa-check"></i> Accept</button>
												<button type="button" class="btn btn-danger actionStatusButton" sdata="<?php echo $dataLogsVal; ?>" btype="7"><i class="fa fa-times"></i> Reject</button>
											<?php } ?>
										<?php } ?>

										<?php
										if (is_access_id_card_module() == true) {
										?>
											<?php if ($currentPage == 'approved' || ($value['status'] == 'A' && $currentPage == 'all')) { ?>
												<button type="button" style="background-color:<?php echo $cardStatus['T']['color']; ?>" class="btn btn-warnings text-white actionStatusButton" sdata="<?php echo $dataLogsVal; ?>" btype="3"><i class="fa fa-print"></i> Move to Print / Reject</button>

											<?php } ?>

											<?php if ($currentPage == 'printing' || ($value['status'] == 'T' && $currentPage == 'all')) { ?>
												<button type="button" style="background-color:<?php echo $cardStatus['C']['color']; ?>" class="btn btn-warnings text-white actionStatusButton" sdata="<?php echo $dataLogsVal; ?>" btype="4"><i class="fa fa-check"></i> Print Received / Reject </button>
												<button type="button" class="btn btn-primary" sdata="<?php echo $dataLogsVal; ?>" onclick=printIdCard('<?php echo $value['user_id']; ?>'); title="print"><i class="fa fa-print"></i></button>
											<?php } ?>

											<?php if ($currentPage == 'distribute' || ($value['status'] == 'C' && $currentPage == 'all')) { ?>
												<button type="button" style="background-color:<?php echo $cardStatus['D']['color']; ?>" class="btn btn-warnings text-white actionStatusButton" sdata="<?php echo $dataLogsVal; ?>" btype="5"><i class="fa fa-sign-in"></i> Handover to HR</button>
											<?php } ?>

											<?php if ($currentPage == 'handover' || ($value['status'] == 'D' && $currentPage == 'all')) { ?>
												<button type="button" style="background-color:<?php echo $cardStatus['H']['color']; ?>" class="btn btn-warnings text-white actionStatusButton" sdata="<?php echo $dataLogsVal; ?>" btype="6"><i class="fa fa-check"></i> Collected by Employee</button>
											<?php } ?>

											<?php if ($currentPage == 'allcheck') { ?>
												<button type="button" style="background-color:<?php echo $cardStatus['H']['color']; ?>" class="btn btn-warnings text-white actionStatusButton" sdata="<?php echo $dataLogsVal; ?>" btype="8"><i class="fa fa-sign-in"></i> Update Status</button>
											<?php } ?>

										<?php
										} ?>
									</td>
								</tr>
							<?php
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</section>
</div>


<div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="changeStatusLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Status</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>

					<div class="form-group">
						<label for="status">Select Status</label>
						<select class="form-control" name="log_status" id="status" required>
							<option value="">-- Choose --</option>
						</select>
					</div>

					<div class="form-group">
						<label for="remarks">Remarks</label>
						<textarea type="text" class="form-control" id="remarks" col="10" rows="50" placeholder="Remarks" required></textarea>
					</div>
					<hr />
					<div class="form-group">
						<input type="hidden" id="application_id" value="" required>
						<input type="hidden" id="user_id" value="" required>
						<button type="button" class="btn btn-primary" id="updateIDStatus" data-dismiss="modal">Submit</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>

<script>
    $(function () {
        $('#multiselect').multiselect();       
        $('#office_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>




<div class="modal fade" id="changeStatusBulk" tabindex="-1" role="dialog" aria-labelledby="changeStatusLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Bulk Status</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<span style="color:#e81111cc;font-weight:600" id="bulkCounters"><b>2 ID Card Selected</b></span>
					</div>

					<br />

					<div class="form-group">
						<label for="status">Select Status</label>
						<select class="form-control" name="log_status" id="status" required>
							<option value="">-- Choose --</option>
						</select>
					</div>

					<div class="form-group">
						<label for="remarks">Remarks</label>
						<textarea type="text" class="form-control" id="remarks" col="10" rows="50" placeholder="Remarks" required></textarea>
					</div>
					<hr />
					<div class="form-group">
						<input type="hidden" id="application_id" value="" required>
						<button type="button" class="btn btn-primary" id="updateIDStatusBulk" data-dismiss="modal">Submit</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>

<!-- <form id="prnform" method="post">
	<input type="hidden" name="user_id" id="user_id">
</form> -->

		<div id="raw_img" style="display: none;">

						</div>
		<canvas id="img">

						</canvas>
		<a id="cnv_url" href="" download>download</a>

	
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script>
	function printIdCard(user_id) {
		$("#prnform #user_id").val(user_id);


		$.post("<?= base_url() ?>employee_id_card/create_id_card_image", {
			user_id: user_id
		}).done(function(data) {
			$("#raw_img").html(data);
			var html=$("#raw_img #dwn_image").html();
			$("#img").html(html);
			// var aelement = document.querySelector("#img");
			// console.log(aelement);
			var file;
		var can = document.getElementsByTagName("canvas");
		console.log(can);
		file = can[0].innerHTML.toDataURL('image/jpeg');
		console.log(file);
		$("#cnv_url").attr("href",file);
			// html2canvas(aelement, {
			// 	onrendered: function(canvas) {
			// 		// $("#box").html("");
			// 		// $("#box").append(canvas);
			// 		getCanvas = canvas;
			// 		console.log(canvas);
			// 		// convrting canvas to image and appening
			// 		var image = new Image();
			// 		image.src = canvas.toDataURL("image/jpeg");
			// 		console.log(image);
			// 		$("#img").append(image);
			// 		// setting geneated img url as href of #b
			// 		var foo = canvas.toDataURL("image/jpeg");
			// 		// console.log("foo" + foo);   
			// 		$("#b").attr("href", foo);






			// 	}

			// });
			// upload_images();

		});






		// $("#prnform").attr("action","<?php echo base_url(); ?>employee_id_card/generateCard_show");
		// $("#prnform").attr("target","_blank");
		// $("#prnform").submit();  

	}

	function upload_images() {
		
		var dat = new FormData();

		var file;
		var can = document.getElementsByTagName("canvas");
		console.log(can);
		file = can[0].toDataURL('image/jpeg');
		// console.log(file);
		$("#cnv_url").attr("href",file);
		file = file.replace(/^data:image\/(png|jpg|jpeg);base64,/, '');		
		dat.append('images', file);
		$.ajax({
			url: "employee_id_card/upload_id_card_images",
			type: "POST",
			data: dat,
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function() {
				//$("#preview").fadeOut();
				// $("#err").fadeOut();
				// console.log(dat);
			},
			success: function(response) {
				if (response == 'invalid file') {
					// invalid file format.
					// $("#err").html("Invalid File !").fadeIn();
					alert(response);
				} else {
					// view uploaded file.
					// $("#preview").html(response).fadeIn();
					// alert(response);
					// console.log(response);
					// $("#form")[0].reset();
				}
			},
			error: function() {
				alert("error2")
				// $("#err").html(e).fadeIn();
			}
		});
	}
</script>