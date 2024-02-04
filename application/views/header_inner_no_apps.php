<nav class="navbar navbar-expand-lg">
	<div class="container-fluid">
		<a class="navbar-brand" href="<?php echo base_url() ?>home"><?= get_logo() ?></a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="mynavbar">
			
			<div class="d-flex navbar-right">
				<div class="dropdown language">
					<button type="button" class="btn dropdown-toggle transparent_background lang_btn " data-toggle="dropdown">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/language.svg" alt=""> <span id="lang_disp">English</span>
					</button>
					<ul class="dropdown-menu trannslang">
						<li><a class="dropdown-item flag_link eng" data-lang="en" href="javascript:void(0);">English</a></li>
						<li><a class="dropdown-item flag_link frn" data-lang="fr" href="javascript:void(0);">French</a></li>
					</ul>

					<div id="google_translate_element"></div>

				</div>
				



				<div class="dropdown log_out">
					<img src="<?= getProfileImg() ?>" class="profile_img" alt="">
					<button type="button" class="btn btn-primary dropdown-toggle transparent_background" data-toggle="dropdown">
						<?php echo get_username(); ?><br>
						<small><?php echo " (" . get_role() . ", " . get_deptshname() . ")" ?></small>
					</button>
					<ul class="dropdown-menu">
						
						<?php if (get_login_type() == "client") { ?>
							<li><a class="dropdown-item" href="<?php echo base_url(); ?>clientlogin/changePasswd"><img src="<?php echo base_url(); ?>assets_home_v3/images/change_password.svg" class="menu_icon_log" alt=""> Changes Password</a></li>
						<?php } else { ?>
							<li><a class="dropdown-item" href="<?php echo base_url() . get_role_dir(); ?>/changePasswd"><img src="<?php echo base_url(); ?>assets_home_v3/images/change_password.svg" class="menu_icon_log" alt=""> Changes Password</a></li>
						<?php } ?>

						<li>
							<hr class="dropdown-divider">
						</li>
						<li><a class="dropdown-item" href="javascript:void(0);" id="btnLogoutModel"><img src="<?php echo base_url(); ?>assets_home_v3/images/log_out.svg" class="menu_icon_log1" alt=""> Log Out</a></li>
					</ul>
				</div>

				<a href="javascript:void(0);" class="hover_efect" data-toggle="modal" data-target="#myModal2">
					<img src="<?php echo base_url(); ?>assets_home_v3/images/help.png" class="" alt="">
				</a>
			</div>
		</div>
	</div>

	<?php $uri = $this->uri->segment(2); ?>
	<?php if ($uri == 'view_courses') { ?>
		<div>
			<ul id="top-nav" class="pull-right">
				<li class="nav-item dropdown">
					<div id="redBecomesBlue" class="red small" title="Your Progress"></div>
				</li>
			</ul>
		</div>
	<?php }  ?>
</nav>

<!--start sidebar help icon-->
<div class="model_side modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
				<h4 class="avail_title_heading" id="myModalLabel2">Help & Support</h4>
			</div>

			<div class="modal-body">
				<?php include_once('help_support_rightpanel.php'); ?>
			</div>

		</div>
	</div>
</div>
<!--end sidebar help icon-->