<?php
/*---------------------------------------------------------------------------------------
Check The current URL and moniter the links,

If the session is on then a user can jump between the three dashboards irrespective of the 
session he is logged in. In order to stop that the below is written, which will check the change 
in URL and and search for admin, agent and coach keywords present in the url. Then based on the 
keywords will assign a 404 error page. 

----------------------------------------------------------------------------------------*/
is_valid_session_url();
$url= (explode("/",$_SERVER['REQUEST_URI']));
$url_data = $url[1];

?>
<!DOCTYPE html>

<head>
	<meta charset="UTF-8">
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
	<!-- <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> -->


	<!--<link rel="stylesheet" href="<?php //echo base_url() 
										?>libs/bower/font-awesome/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
	<!-- build:css ../assets/css/app.min.css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/animate.css/animate.min.css">

	<!-- <link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/fullcalendar/dist/fullcalendar.min.css"> -->

	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.min.css">

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui-timepicker.css">

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/app.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/uploadfile.css" />

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/inagecrop/imgareaselect.css">

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.min.css">

	<!-- Rich Text Editor -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/custom.css">

	<!-- start added inner header implementation -->

	<?php if($url_data == 'mwpuat'){?>
        <link href="<?php echo base_url() ?>assets_inner_v3/css/inner_common_header_uat.css" rel="stylesheet">
     <?php } else {?>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets_inner_v3/css/inner_common_header.css">
        <?php } ?>
	
	<!-- end added inner header implementation -->


	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	
	<!--end custom chat design library here 27.01.2022-->
	<?php
	if (isset($content_css) && !empty($content_css)) {
		if (is_array($content_css)) {
			foreach ($content_css as $key => $css_url) {
				if (preg_match("/\Ahttp/", $css_url)) {
					echo '<link rel="stylesheet" href="' . $css_url . '">';
				} else {
					echo '<link rel="stylesheet" href="' . base_url("assets/css/" . $css_url) . '">';
				}
			}
		} else {
			if (preg_match("/\Ahttp/", $content_css)) {
				echo '<link rel="stylesheet" href="' . $content_css . '">';
			} else {
				echo '<link rel="stylesheet" href="' . base_url("assets/css/" . $content_css) . '">';
			}
		}
	}
	?>

	<style>
		#global_notify_count {
			padding: 2px 5px 2px 5px;
			background: #cc0000;
			color: #ffffff;
			font-weight: bold;
			margin-left: 26px;
			border-radius: 9px;
			position: absolute;
			margin-top: -48px;
			font-size: 11px;
		}

		.case-wrapper {
			margin: 0 auto;
			float: left;
			width: 70px;
			height: 87px;
			margin: 6px;
			display: inline-block;
		}

		.case-label {
			font-size: 10px;
			font-weight: bold;
			letter-spacing: 0.4px;
			color: darkblue;
			text-align: center;
			margin-top: 1px;
			transition: 0.2s;
			-webkit-transition: 0.2s;
			text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.5), 0px 1px 5px rgba(0, 0, 0, 0.5);
		}

		.app-icon {
			padding: 18px;
			display: inline-block;
			margin: auto;
			text-align: center;
			border-radius: 16px;
			cursor: pointer;
			box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.15);
		}

		.app-icon .inner,
		.app-icon i {
			font-size: 32px;
			min-width: 32px;
			color: #fafbfc;
			display: inline-block;
			transition: 0.2s;
			-webkit-transition: 0.2s;
			text-shadow: -1px 1px 5px rgba(0, 0, 0, 0.15);
		}

		.app-icon .inner {
			line-height: 32px;
			font-weight: bold;
		}

		.app-icon svg,
		.app-icon img {
			height: 32px;
			width: 32px;
		}

		.app-icon path {
			fill: #fafbfc;
			transition: 0.2s;
			-webkit-transition: 0.2s;
		}

		.circle {
			position: absolute;
			right: 20px;
			top: -10px;
			color: #fff;
			background-color: #ff5858;
			padding: 6px;
			font-size: 12px;
			line-height: 1;
			border-radius: 25px;
			min-width: 25px;
			height: 25px;
			text-align: center;
			text-shadow: none;
			letter-spacing: normal;
			cursor: pointer;
		}

		.app-icon:hover path {
			fill: #fff;
		}

		.app-icon:hover i,
		.app-icon:hover {
			color: #fff;
		}

		.app-icon-small {
			padding: 12px;
		}

		.app-icon-img.app-icon-small {
			padding: 0px;
			height: 54px;
			width: 54px;
		}

		.app-icon-img {
			padding: 0px;
			height: 100px;
			width: 100px;
		}

		.app-icon-img img {
			width: 100%;
			height: 100%;
		}

		.rtl {
			direction: rtl;
		}

		.apps_grid {

			margin: 0 auto;
			display: block;
		}

		.waterMark {
			background-color: #FFFFFF;
			opacity: 0.2;
		}

		body.sb-left .app-navbar {
			left: 0px;
			margin-left: 220px;

		}


		#google_translate_element {
			display: none;
		}

		.goog-te-banner-frame.skiptranslate {
			display: none !important;
		}

		body {
			top: 0px !important;
		}

		body.modal-open {
			padding-right: 0px !important;
		}

		body:not(.modal-open) {
			padding-right: 0px !important;
		}

		/*start custom chatbot design css here*/
		.chat-bottom {
			position: fixed;
			width: 400px;
			/*height:570px;*/
			bottom: 0;
			right: 0;
			background-color: transparent;
		}

		.chat-bottom iframe {
			width: 100%;
			height: 100%;
			border: none;
			padding: 10px;
			background-color: transparent;
		}

		/*end custom chatbot design css here*/

		/*start video popup css here*/
		.video-btn {
			width: 35px;
			height: 35px;
			display: inline-block;
			background: #103978;
			color: #fff;
			padding: 0;
			text-align: center;
			margin: 15px 10px 0 0;
			border-radius: 40px;
			transition: all 0.5s ease-in-out 0s;
			border: none;
			cursor: pointer;
			position: absolute;
			top: -10px;
			right: 30px;
		}

		/*end video popup css here*/
		/*start new icon widget for chatbot 25.03.2022*/
		.icon-small-new {
			height: 90px;
			cursor: pointer;
		}

		.close-area {
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			line-height: 90px;
			width: 90px;
			height: 90px;
			display: none;
			justify-content: center;
			align-items: center;
			background: #2c5da9;
			border-radius: 50%;
			text-align: center;
			color: #fff;
			font-size: 25px;
			cursor: pointer;
		}

		.omind-widget1 {
			width: auto;
			height: auto;
		}

		/*end new icon widget for chatbot 25.03.2022*/

		/*For aside bar logo spacing*/
		#brand-name img {
			margin: 0 0 0 0;
			height: 60px;
		}

		.brand-icon {
			margin-top: 0 !important;
		}
	</style>
	<?php /*if(get_login_type() != "client" && empty($disable_ameyo_chat)){ ?>
	<script type="text/javascript" language="javascript" src="https://wfh.ameyoengage.com:8443/ameyochatjs/ameyo-emerge-chat.js" async defer></script>   
	<script type="text/javascript"> 
	<?php
	$_ameyo_noFlowID = '5';
	$_ameyo_officeid = get_user_office_id();
	if(!empty($_ameyo_officeid) && $_ameyo_officeid == 'ALT'){ $_ameyo_noFlowID = '20'; }
	if(!empty($_ameyo_officeid) && isIndiaLocation($_ameyo_officeid)){ $_ameyo_noFlowID = '53'; }
	?>
	var campaignId = '11';
	var nodeflowId = '<?php echo $_ameyo_noFlowID; ?>';
	var ameyoUrl = 'https://wfh.ameyoengage.com:8443'
	var phoneNoRegex = "^[+]{0,1}[0-9]{9,16}$";

	var ameyo_script = document.createElement('script');
	ameyo_script.onload = function() {
			try {
				initializeChat(campaignId, nodeflowId,ameyoUrl,null,null,null,null,null, phoneNoRegex);
			} catch (err) {
				console.error( err);
			}
		};
	ameyo_script.src = ameyoUrl+"/ameyochatjs/ameyo-emerge-chat.js";
	document.getElementsByTagName('head')[0].appendChild(ameyo_script);
	</script>
<?php }*/ ?>

	<!-- <script src="<?php echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script> -->
	<script src="<?php echo base_url() ?>libs/jquery/jquery-3.5.1.js"></script>
</head>

<body class="sb-left">

	<!--Start Loader element-->
    <div class="loading_main" id="page_loader">
        <div class="loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!--End Loader element-->
	<!--============= start main area -->

	<?php include_once $aside_template; ?>

	<?php
	$profileURL = "";
	if ($content_template == "home/change_passwd.php" || $content_template == "home/pending_process_policy.php") {
		$profileURL = "";
	} else {
		$profileURL = base_url() . "profile";
	}

	if (get_login_type() == "client")
		$profileURL = base_url() . "#";
	?>		

	<!--start new header implement-->
	<?php include_once('header_inner.php'); ?>
	<!--end new header implement-->


	<!-- APP MAIN ==========-->
	<main id="app-main" class="app-main">

		<div id='main_page_content'>
			<?php include_once $content_template; ?>
		</div>


		<!-- Modal Start here-->

		<div class="modal fade bs-example-modal-sm" id="sktPleaseWait" tabindex="-2" role="dialog" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">
							<i class="fa fa-refresh fa-spin" style="font-size:16px"></i>&nbsp;&nbsp;Please Wait. Processing...
						</h4>
					</div>
					<div class="modal-body">
						<div class="progress">
							<div class="progress-bar progress-bar-info progress-bar-striped active" style="width: 100%">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</main>

	<!--start footer elements-->   
	<?php include_once('footer_inner.php'); ?>
    <!--end footer elements-->



	<div id="LogoutImgModelAd" class="modal fade" role="dialog" aria-labelledby="confirmAcknowledgeLabel" aria-hidden="true">
		<div class="modal-dialog" style='width:40%;'>
			<!-- Modal content-->
			<div class="modal-content">
				<form class="frmAdLogoutAcknowledge" action="<?php echo base_url(); ?>logout" data-toggle="validator" method='POST'>
					<div class="modal-body">
						<img style='width:100%;' src="<?php echo base_url(); ?>assets/images/ad_logout_img.png" />
						<br><br>
						<div class="row">
							<div class="col-md-12" style="color:darkgreen;font-weight:bold; font-size:16px;">
								<input type="checkbox" id="is_acknowledge" name="is_acknowledge" value='1' required>
								I acknowledge the same
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" id="confirm">I acknowledge</button>

					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="LogoutImgModel" class="modal fade">
		<div class="modal-dialog" style='width:40%;'>
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<img style='width:100%;' src="<?php echo base_url(); ?>assets/images/fems_logout_popup_2021.jpg" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>


	<!--========== END app main -->

	<!-- build:js ../assets/js/core.min.js -->

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/superfish/dist/js/hoverIntent.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/superfish/dist/js/superfish.js"></script>

	<script src="<?php echo base_url() ?>libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>

	<!--<script src="<?php echo base_url() ?>libs/bower/PACE/pace.min.js"></script>-->

	<script src="<?php echo base_url() ?>assets/js/select2.full.min.js"></script>

	<script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.maskedinput.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-number-input.js"></script>

	<script src="<?php echo base_url() ?>assets/js/bootstrap-select.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap.validator.min.js"></script>

	<script src="<?php echo base_url() ?>assets/js/jquery.form.js"></script>
	<script src="<?php echo base_url() ?>assets/inagecrop/jquery.imgareaselect.js" type="text/javascript"></script>

	<!-- endbuild -->

	<!-- build:js ../assets/js/app.min.js -->
	<script src="<?php echo base_url() ?>assets/js/library.js"></script>
	<script src="<?php echo base_url() ?>assets/js/plugins.js"></script>
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>
	<!-- endbuild -->

	<script src="<?php echo base_url() ?>libs/bower/moment/moment.js"></script>
	<!--	<script src="<?php echo base_url() ?>assets/js/fullcalendar.js"></script> -->
	<script src="<?php echo base_url() ?>assets/js/jquery.uploadfile.js"></script>

	<!-- Added on Last
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
	
	<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>

	<script src="<?php echo base_url() ?>assets/js/skt.common.js"></script>

	<!-- Rich Text Editor -->
	<script src="<?php echo base_url() ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

	<!--for inner pages -->
	<?php include_once('inner_pages/all_popup_inner.php'); ?>
	<?php include_once('jscripts/all_inner_js.php'); ?>
	<!--for inner pages-->

	
	<script type="text/javascript">
		function googleTranslateElementInit() {

			var tlang = $.cookie('tlang');
			if (tlang == "") tlang = "en";
			var lang = tlang;
			new google.translate.TranslateElement({
				pageLanguage: 'en',
				includedLanguages: 'en,fr'
			}, 'google_translate_element');
			var languageSelect = document.querySelector("select.goog-te-combo");
			languageSelect.value = lang;
			languageSelect.dispatchEvent(new Event("change"));
		}

		var flags = document.getElementsByClassName('flag_link');

		Array.prototype.forEach.call(flags, function(e) {
			e.addEventListener('click', function() {
				var lang = e.getAttribute('data-lang');
				$.cookie('tlang', lang, {
					expires: 900,
					path: '/'
				});

				var languageSelect = document.querySelector("select.goog-te-combo");
				languageSelect.value = lang;
				languageSelect.dispatchEvent(new Event("change"));



			});
		});
	</script>

<script>
   $(window).on("load", function() {
        $("#page_loader").fadeOut();
    });

    $(window).on("load",function(){

        $(".trannslang li a").click(
            function(){ 
                googleTranslateElementInit();
                dt=$(this).text();
                if(dt=='Anglais')dt='English';
                $("#lang_disp").html(dt);
            }
        );
    });
     
</script>


	<?php include_once 'jscripts.php' ?>


	<?php
	if (isset($content_js) && !empty($content_js)) {
		if (is_array($content_js)) {

			foreach ($content_js as $key => $script_url) {
				if (!preg_match("/.php/", $script_url)) {
					if (preg_match("/\Ahttp/", $script_url)) {
						echo '<script src="' . $script_url . '"></script>';
					} else {
						echo '<script src="' . base_url('application/views/jscripts/' . $script_url) . '"></script>';
					}
				} else {
					include_once 'application/views/jscripts/' . $script_url;
				}
			}
		} else {
			if (!preg_match("/.php/", $content_js)) {
				if (preg_match("/\Ahttp/", $content_js)) {
					echo '<script src="' . $content_js . '"></script>';
				} else {
					echo '<script src="' . base_url('application/views/jscripts/' . $content_js) . '"></script>';
				}
			} else {
				include_once 'application/views/jscripts/' . $content_js;
			}
		}
	}
	?>
</body>
<?php
$usrNm = get_username();
$uName = explode(" ", $usrNm);
$userName = $uName['0'];
?>
<script>
	window.addEventListener('load', function() {
		loadScript("//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit");
	});

	function loadScript(src) {
		return new Promise(function(resolve, reject) {
			if ($("script[src='" + src + "']").length === 0) {
				var script = document.createElement('script');
				script.onload = function() {
					resolve();
				};
				script.onerror = function() {
					reject();
				};
				script.src = src;
				document.body.appendChild(script);
			} else {
				resolve();
			}
		});
	}
</script>
<!--end custom chat design library here 27.01.2022-->

<!--start Mega menu search js code-->
<script>
	$(document).ready(function() {	
        $("#autosuggest_input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".mega-menu li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

	

	
</script>
<!--end Mega menu search js code-->

<!-- Start Inner Side Bar -->
<script src="<?php echo base_url() ?>assets_inner_v3/js/metisMenu.min.js"></script>
<script src="<?php echo base_url() ?>assets_inner_v3/js/main.js"></script>
<!-- End Inner Side Bar -->

</html>