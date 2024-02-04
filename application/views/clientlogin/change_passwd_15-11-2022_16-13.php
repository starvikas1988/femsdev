<?php 

/*---------------------------------------------------------------------------------------

Check The current URL and moniter the links,

If the session is on then a user can jump between the three dashboards irrespective of the 
session he is logged in. In order to stop that the below is written, which will check the change 
in URL and and search for admin, agent and coach keywords present in the url. Then based on the 
keywords will assign a 404 error page. 

----------------------------------------------------------------------------------------*/

is_valid_session_url();



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo APP_TITLE;?></title>
	
	<?php
	header( 'Cache-Control: no-store, no-cache, must-revalidate' ); 
	header( 'Cache-Control: post-check=0, pre-check=0', false ); 
	header( 'Pragma: no-cache' ); 
	?>

	<meta name="description" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
	<!-- build:css ../assets/css/app.min.css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.css">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.min.css">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui-timepicker.css">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/app.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/uploadfile.css"/>
	
	
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
	
	
.app-footer1 {
	padding: 24px 0;
	border-top: 1px solid #cccccc;
}
	
  .app-footer1 .copyright1 {
    font-weight: 400;
    color: #aaacae;
    letter-spacing: 1.5px; 
	text-align:center;
	}
	
</style>
	
<style>
.searchInput{
    width: 500px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    background-color: white;
    background-image: url('<?php echo base_url();?>assets/images/searchicon.png');
    background-position: 6px 6px; 
    background-repeat: no-repeat;
    padding: 6px 10px 6px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
	margin-top:12px;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";       /* IE 8 */
	filter: alpha(opacity=50);  /* IE 5-7 */
	-moz-opacity: 0.5;          /* Netscape */
	-khtml-opacity: 0.5;        /* Safari 1.x */
	opacity: 0.5;               /* Good browsers */
}
.searchInput:focus{
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";       /* IE 8 */
	filter: alpha(opacity=100);  /* IE 5-7 */
	-moz-opacity: 1;          /* Netscape */
	-khtml-opacity: 1;        /* Safari 1.x */
	opacity: 1;               /* Good browsers */
	width: 500px;
}

</style>


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
	  margin:6px;
	  display:inline-block;
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
	
	.apps_grid{
		
		margin: 0 auto;
		display:block;
	}

	.waterMark{
		background-color: #FFFFFF;    
		opacity: 0.2;
	}


</style>

<script src="<?php echo base_url() ?>libs/bower/jquery/dist/jquery.js"></script>

</head>
	
<body>
<!--============= start main area -->

<?php //include_once $aside_template; 

?>


<!-- APP NAVBAR ==========-->
<nav id="app-navbar" class="app-navbar p-l-lg p-r-md primary">

	
	<div id="navbar-header" class="pull-left">
		<a href="" >
			<div class="pull-left"><img src="<?php echo base_url(); ?>assets/images/profile.png" style="height: 50px; margin-right:15px"/></div>
		</a>
		<a href="<?php echo base_url()?>profile" >
		<h5 id="page-title" class="visible-md-inline-block visible-lg-inline-block m-l-md">
			
			<?php
				echo get_username()." - (".get_user_office_id().")";
			?>
		</h5>
		</a>
		
	</div>
	
	<div>
		<ul id="top-nav" class="pull-right">
						
			<li class="nav-item dropdown">
				<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-hc-2x zmdi-settings"></i></a>
				<ul class="dropdown-menu animated flipInY">
					<!--<li><a href="<?php //echo base_url(); ?>"><i class="zmdi m-r-md zmdi-hc-lg zmdi-account-box"></i>Change Password</a></li>-->
					<li><a href="<?php echo base_url();?>client/client_logout"><i class="zmdi m-r-md zmdi-hc-lg zmdi-sign-in"></i>Logout</a></li>
				</ul>
			</li>

		</ul>
	</div>	
	
	<?php
		$global_notify_count=get_notify_count();
		if($global_notify_count>0){
	?>
	
	<div>
		<ul id="top-nav" class="pull-right">
			<li class="nav-item dropdown">
				<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-exclamation-triangle"></i></a>
				
				<ul id='global_notify_div' class="dropdown-menu animated flipInY">
					
					<?php
						//echo get_notify_html();
					?>
				</ul>
				
				<span id="global_notify_count"><?php echo $global_notify_count;?></span>
				
			</li>
		</ul>
	</div>
	
	<?php } ?>
	
	
	<!--<div>
		<ul id="top-nav" class="pull-right">
						
			<li class="nav-item dropdown">
				<a href="<?php //echo base_url();?>home" class="dropdown-toggle" role="button" aria-haspopup="false" aria-expanded="false"><i class="zmdi zmdi-hc-2x zmdi-home"></i></a> 
			</li>

		</ul>
	</div>-->
	
	
</nav>
<!--========== END app navbar -->


<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">

	<div id='main_page_content'>
		<?php //include_once $content_template; ?>
		
		
		<!--========== Wrap class start -->
		

<div class="wrap">
	<section class="app-content">	
	
		<div class="simple-page-wrap">
			
			<div class="simple-page-form animated flipInY">
				<h4 class="form-title m-b-xl text-center">Change Password</h4>
				
				<?php if($error!='') echo $error; ?>
					
				<form action="<?php echo base_url(); ?>clientlogin/change_password" data-toggle="validator" autocomplete="off" method='POST'>
					
					<input type="text" name="dummyuser" value="chose" style="display: none" />
					
					
					<input type="hidden" id="old_pswd" name="old_pswd" value="<?php echo $old_pswd[0]['passwd']; ?>" />
					
					<div class="form-group">
						<input id="old_password" type="password" class="form-control" placeholder="Type Your Old Password" name="old_password" required>
					</div>

					<div class="form-group">
						<input id="new_password" type="password" class="form-control" data-minlength="8" placeholder="Type New Password" name="new_password" pattern="(?=^.{6,40}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&amp;*()_+}{&quot;:;'?/&gt;.&lt;,])(?!.*\s).*$" required>
						<div class="help-block">Password should contain atleast 1-UC Character, 1-LC Character, Special Character, Number and minimum of 8 digits</div>
					</div>
					
					<div class="form-group">
						<input id="re_password" type="password" class="form-control" placeholder="Re-type Password" data-match="#new_password" data-match-error="Whoops, password doesn't match" name="re_password" required>
						<div class="help-block with-errors"></div>
					</div>

					<input type="submit" class="btn btn-success" value="Save" name="submit">
				</form>
			</div>

		</div>
			
</section> 
</div>


<div>
	
	<!-- APP FOOTER -->
	<div class="wrap p-t-0">
		<footer class="app-footer1">
			<div class="copyright1">&copy; <?php echo date("Y");?> Fusion BPO Services</div>
		</footer>
	</div>
	<!-- /#app-footer -->
	
	
	<!-- Modal Start here-->
<div class="modal fade bs-example-modal-sm" id="sktPleaseWait" tabindex="-2" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
					<i class="fa fa-refresh fa-spin" style="font-size:16px"></i>&nbsp;&nbsp;  Processing...
                 </h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-info
                    progress-bar-striped active"
                    style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

<!--========== END app main -->
	
	<!-- build:js ../assets/js/core.min.js -->
	
	<script src="<?php echo base_url() ?>libs/bower/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/superfish/dist/js/hoverIntent.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/superfish/dist/js/superfish.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
	<script src="<?php echo base_url() ?>libs/bower/PACE/pace.min.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/select2.full.min.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.maskedinput.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-number-input.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/bootstrap-select.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap.validator.min.js"></script>
	
	<!-- endbuild -->

	<!-- build:js ../assets/js/app.min.js -->
	<script src="<?php echo base_url() ?>assets/js/library.js"></script>
	<script src="<?php echo base_url() ?>assets/js/plugins.js"></script>
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>
	<!-- endbuild -->
			
	<script src="<?php echo base_url() ?>libs/bower/moment/moment.js"></script>	
	<script src="<?php echo base_url() ?>assets/js/fullcalendar.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.uploadfile.js"></script>
	<script src="<?php echo base_url() ?>assets/js/skt.common.js"></script>
	
	<?php //include_once 'jscripts.php' ?>
		
<!-------------------------------------------------------------------------------->
