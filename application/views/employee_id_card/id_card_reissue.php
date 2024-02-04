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
		margin-top:23px;
	}
</style>

<div class="wrap">
	<section class="app-content">

		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">Re-issue ID Card</h4>
			</header>
			<hr class="widget-separator">
			<div class="widget-body ">
				<?php
				//if(get_global_access()==true){
				?>

				<form method="GET" action="<?php echo base_url('employee_id_card/reissue_id_card'); ?>" id="reissue_form">
					<div class="row">
					<div class="col-md-4">
						<div class="form-group filter-widget">
								<label>Enter Fusion ID</label>
								<input type="text" name="fusion_id" id="fusion_id" class="form-control" placeholder="Please enter fusion id" required>
								
							</div>
								</div>

						<div class="col-md-4">
							<div class="form-group filter-widget">
								<label>Reasons To Re-issue ID Card</label>
								<select  class="form-control" name="reason" id="reason" required >
								<option value="">Please Select</option>
								<option value="1" >ID Card Damage</option>
								<option value="2" >ID Card Stolen/Lost</option>
								<option value="3" >Old Employee ID Card not getting</option>
								<option value="4" >ID Card approved, but not showing Approval section</option>
								
								</select>
							</div>
						</div>
						

						<div class="col-md-1">
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-new" id="submit"><i class="bi bi-arrow-clockwise"></i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
								<path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
								</svg>Re-issue ID Card</button>
							</div>
						</div>

					</div>
				</form>
				<?php
				//}
				?>
			</div>
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
<script>
			$( document ).ready(function() {
				$("#reason").change(function() {
				$("#submit").attr("disabled", true);
				var fid = $('#fusion_id').val();
				
				if(fid!="")
				{
					if (/^[a-zA-Z0-9- ]*$/.test(fid) == false) {
						alert('Your Fusion id contains illegal characters.');
						$("#submit").attr("disabled", true);
						$('#reissue_form')[0].reset();
					}
					else{
						$.ajax({
							url: "<?php echo base_url(); ?>employee_id_card/reissue_id_card_check",
							type: "POST",
							data: {
								fid: fid
							},
							success: function(result) {

								
								if (result == 1) {
									alert("ID card cannot be reissued for this employee. Ask employee to apply for new ID-Card.");
									$("#submit").attr("disabled", true);
									$('#reissue_form')[0].reset();
								} else if (result == 2) {
									alert('ID card can be re-issued for Active Users only.');
									$("#submit").attr("disabled", true);
									$('#reissue_form')[0].reset();
								} else if (result == 3) {
									alert('Invalid Fusion ID.');
									$("#submit").attr("disabled", true);
									$('#reissue_form')[0].reset();
								}else if (result == 4) {
									alert('User Already in pending For HR List. Are you still Want to Re-issue his/her ID Card?');
									$("#submit").attr("disabled", false);
									//$('#reissue_form')[0].reset();
								} else {
									$("#submit").attr("disabled", false);
								}
							}
						});
					}
				}
				
				
				
				

				});

			});
		</script> 