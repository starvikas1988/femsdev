<?php
/*---------------------------------------------------------------------------------------
Check The current URL and moniter the links,

If the session is on then a user can jump between the three dashboards irrespective of the 
session he is logged in. In order to stop that the below is written, which will check the change 
in URL and and search for admin, agent and coach keywords present in the url. Then based on the 
keywords will assign a 404 error page. 

----------------------------------------------------------------------------------------*/
is_valid_session_url();

if (check_logged_in() == false) {
	if(get_login_type()=="vendor") redirect(base_url()."vendorlogin", "refresh");
	else redirect(base_url(), "refresh");
}
else {
	if(get_login_type()=="client") redirect(base_url(), "refresh");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	?>

	<title><?php echo APP_TITLE; ?></title>
	<?php if (strpos($content_template, 'egaze/') !== false) { ?>

		<meta name="Smart Employee Monitoring Solution.">

	<?php } else { ?>
		<meta name="description" content="<?php echo get_role(); ?> Dashboard" />
	<?php } ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.ico" type="image/x-icon">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.bootstrap.min.css"> -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">


	<!-- need to keep this in head -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/2.1.1/sweetalert2.min.css">
	<!-- need to keep this in head -->

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/procurement/css/custom.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/procurement/css/style.css">


	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/procurement/css/bootstrap-multiselect.css">
	<script src="<?php echo base_url(); ?>assets/procurement/js/bootstrap-multiselect.js"></script>

	<?php
	if (isset($content_css) && !empty($content_css)) {
		if (is_array($content_css)) {
			foreach ($content_css as $key => $css_url) {
				if (preg_match("/\Ahttp/", $css_url)) {
					echo '<link rel="stylesheet" href="' . $css_url . '">';
				} else {
					echo '<link rel="stylesheet" href="' . base_url("assets/procurement/css/" . $css_url) . '">';
				}
			}
		} else {
			if (preg_match("/\Ahttp/", $content_css)) {
				echo '<link rel="stylesheet" href="' . $content_css . '">';
			} else {
				echo '<link rel="stylesheet" href="' . base_url("assets/procurement/css/" . $content_css) . '">';
			}
		}
	}
	?>

</head>

<body>
	
	<div class="parent-div">
<!-- START LOADER HTML -->
	<div id="preloader">
			<div id="container" class="container-preloader">
				<div class="animation-preloader">
					<div class="spinner"></div>
				</div>	
			</div>
		</div>	
<!-- END LOADER HTML --> 
		<?php include_once $aside_template; ?>
		<section class="main">
			<div class="main-top">
				<div class="header-heading">
					<h5>PROCUREMENT MANAGEMENT SYSTEM</h5>
				</div>

				<div class="dropdown">
					<a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
						<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="profile-user" class="rounded-circle thumb-sm" />
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						<?php if(get_login_type()=="vendor") $linkurl_index = "#"; 
						else $linkurl_index = base_url()."profile"; ?>
						<a class="dropdown-item" href="<?=$linkurl_index?>"><i class="fa fa-user align-self-center icon-xs icon-dual" aria-hidden="true"></i> Profile</a>
						<?php if(get_login_type()=="vendor") $linkurl_index = "#"; 
						else $linkurl_index = base_url().get_role_dir()."/changePasswd"; ?>
						<a class="dropdown-item" href="<?=$linkurl_index?>"><i class="fa fa-cog align-self-center icon-xs icon-dual" aria-hidden="true"></i> Change Passwoard</a>
						<div class="dropdown-divider mb-0"></div>
						<?php if(get_login_type()=="vendor") $linkurl_index = base_url()."vendorlogout"; 
						else $linkurl_index = base_url()."logout" ?>
						<a class="dropdown-item" href="<?=$linkurl_index?>"><i class="fa fa-sign-out align-self-center icon-xs icon-dual" aria-hidden="true"></i> Logout</a>
					</div>
				</div>
			</div>

			<?php include_once $content_template; ?>

				<!-- <footer>
                    <div class="footer-area">
                        <p>Omind Technology © Copyright 2023.</p>
                    </div>
                </footer> -->
		</section>
	</div>

	<?php if ($this->session->flashdata('attn_msg')) {
		$msg = $this->session->flashdata('attn_msg');
		if ($msg['class'] == 'danger') {
	?>
			<script>
				swal({
					title: "Error",
					text: "<?php echo $msg['message']; ?>",
					icon: "warning",
					button: false,
					timer: 5000,
				});
			</script>
		<?php };

		if ($msg['class'] == 'success') {
		?>
			<script>
				swal({
					title: "Success",
					text: "<?php echo $msg['message']; ?>",
					icon: "success",
					button: false,
					timer: 5000,
				});
			</script>
	<?php }
	};
	$this->session->unset_userdata('attn_msg');

	?>
	<?php if (get_login_type() == 'vendor' && get_vendor_pass_expiry() == 1) { ?>
		<div class="modal fade call-modal" id="vendorResetPassword" tabindex="-1" aria-labelledby="vendorContactListLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5">Reset Your Password</h1>

					</div>

					<div class="modal-body filter-field">

						<form id="vendorResetPasswordForm" action="<?php echo base_url(); ?>proc_vendor/vendorPasswordUpdate" method="post">
							<div class="modal-body filter-field ">

								<div class="row filter-field">

									<div class="col-sm-6">
										<div class="form-group mb-3">
											<label>Old Password <span style="color: red;">*</span> </label>
											<input type="password" class="form-control" placeholder="Enter Old Password" name="vendor_old_pass" id="vendor_old_pass" required>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group mb-3">
											<label>New Password<span style="color: red;">*</span> </label>
											<input type="password" class="form-control" placeholder="Enter New Password" id="vendor_new_pass" name="vendor_new_pass" required>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group mb-3">
											<label>Confirm Password<span style="color: red;">*</span> </label>
											<input type="password" class="form-control" id="vendor_con_pass" name="vendor_con_pass" placeholder="Confirm Your Password" required>
										</div>
									</div>


								</div>

							</div>
							<div class="modal-footer new-footer">
								<button type="submit" class="new-btn vendorResetPasswordbtn">Update Password</button>
							</div>
						</form>

					</div>
				</div>
			</div>


		</div>
		<script type="text/javascript">
			$(window).on('load', function() {
				$('#vendorResetPassword').modal({
					backdrop: 'static',
					keyboard: false // to prevent closing with Esc button (if you want this too)
				});
				$('#vendorResetPassword').modal('show');

			});
		</script>
	<?php } ?>
	
	<!-- +++++++++++++++++++++++++++++ modal for request details ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
	<div class="modal fade call-modal" id="viewRequestDataModal" tabindex="-1" aria-labelledby="viewRequestDataModalLabel" aria-hidden="true">
	
	</div>
	<!-- ++++++++++++++++++++++++++++++++++++ end +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src=" https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
	<script src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.min.js"></script>
	   <script>
	$(document).ready(function() {
  setTimeout(function() {
    $('#container').addClass('loaded');
     $('#container').css('background','transparent');
    // Once the container has finished, the scroll appears
    if ($('#container').hasClass('loaded')) {
      // It is so that once the container is gone, the entire preloader section is deleted
      $('#preloader').delay(2000).queue(function() {
        $(this).remove();
      });}
  }, 3000);});

</script>



	<script>
		$(document).ready(function() {
			var table = $('.showdatatable').DataTable({
				responsive: true,
				language: {
					"infoEmpty": "No records available - Got it?",
				}
			});

			//new $.fn.dataTable.FixedHeader(table);

			$("#checkAll").click(function() {
				$('input:checkbox').not(this).prop('checked', this.checked);
			});
		});



		var process_ajax = function(call_back_func = null, request_url, sent_data = "", return_type = 'json', request_type = "POST", contains = "") {
			if (contains === 'file') {
				var processdata = false;
				var contenttype = false;
			} else {
				var processdata = true;
				var contenttype = 'application/x-www-form-urlencoded; charset=UTF-8';
			}
			$.ajax({
				type: request_type,
				url: request_url,
				data: sent_data,
				dataType: return_type,
				processData: processdata,
				contentType: contenttype,
				beforeSend: function() {

					$("#snackbar").remove();
					$("body").append('<div id="snackbar" style="display:none;min-width: 250px;margin-left: -125px;color: #4a4fb3;text-align: center;border-radius: 2px;padding: 16px;position: fixed;z-index: 10;left: 50%;bottom: 50%;font-size: 50px;">Loading Start.</div>');
					$('#snackbar').html('<i class="fa fa-spinner loader" aria-hidden="true"></i>');
					$('#snackbar').show('2000');
					$('.parent-div').css("opacity", "0.5");
					//$('#sktPleaseWait').modal('show');
				},
				success: function(response_text) {
					//$('#sktPleaseWait').modal('hide');
					$('.modal-backdrop').remove();
					$('#snackbar').html('<i class="fa fa-spinner loader" aria-hidden="true"></i>');
					if (call_back_func !== null) {
						call_back_func(response_text);
					}
					$('.parent-div').css("opacity", "1");
				},

				error: function(xhr) {
					//$('#sktPleaseWait').modal('hide');
					$('.modal-backdrop').remove();

					$('#snackbar').html('<i class="fa fa-spinner loader" aria-hidden="true"></i>');
					$('#snackbar').hide('5000');
					$('.parent-div').css("opacity", "1");

				},
				complete: function() {
					$('#snackbar').hide('1000');
					//$('#sktPleaseWait').modal('hide');
					$('.modal-backdrop').remove();
					$('.parent-div').css("opacity", "1");
				}
			});
		};

		function populate_process_combo(cid, def = '', objid = 'process_id', isAll = 'N') {

			var request_url = '<?= base_url() ?>/progression/getProcessList';
			var datas = {
				"cid": cid
			};
			process_ajax(function(response) {
				var json_obj = $.parseJSON(response); //parse JSON

				$('#' + objid).empty();

				if (json_obj == "") {
					if (isAll == 'Y') $('#' + objid).append($('<option></option>').val('0').html('All Process'));
					else $('#' + objid).append($('<option></option>').val('').html('NA'));


				} else {


					if (isAll == 'Y') $('#' + objid).append($('<option></option>').val('0').html('All Process'));
					else $('#' + objid).append($('<option></option>').val('').html('-- Select a Process --'));


					for (var i in json_obj) {
						if (json_obj[i].name != "All Process") {
							$('#' + objid).append($('<option></option>').val(json_obj[i].id).html(json_obj[i].name));
						}
					}


				}

				if (isAll == 'Y') $('#' + objid).val("0");
				if (def != "") $('#' + objid).val(def);
				return true;

			}, request_url, datas, 'text');

		}
	</script>

<?php if(get_login_type() == 'vendor'){ ?>
	<script>
		var idleMax = 25;
	    var idleTime = 0;
	    var idleInterval = setInterval("timerIncrement()", 60000);  // 1 minute interval    
	  	$( "body" ).mousemove(function( event ) { idleTime = 0; });
		function timerIncrement() {
		    idleTime = idleTime + 1;
		    if (idleTime > idleMax) { 
		        window.location="<?=base_url()?>vendorlogin/logout";
		    }
		} 
	</script>

        
	</script>
<?php } ?>

	<?php //include_once 'jscripts.php' ?>


	<?php
	if (isset($content_js) && !empty($content_js)) {
		if (is_array($content_js)) {

			foreach ($content_js as $key => $script_url) {
				if (!preg_match("/.php/", $script_url)) {
					if (preg_match("/\Ahttp/", $script_url)) {
						echo '<script src="' . $script_url . '"></script>';
					} else {
						echo '<script src="' . base_url('jscripts/procurement_js/' . $script_url) . '"></script>';
					}
				} else {
					include_once 'jscripts/procurement_js/' . $script_url;
				}
			}
		} else {
			if (!preg_match("/.php/", $content_js)) {
				if (preg_match("/\Ahttp/", $content_js)) {
					echo '<script src="' . $content_js . '"></script>';
				} else {
					echo '<script src="' . base_url('jscripts/procurement_js/' . $content_js) . '"></script>';
				}
			} else {
				include_once 'jscripts/procurement_js/' . $content_js;
			}
		}
	}
	?>
</body>

</html>