<aside id="app-aside" class="app-aside left light">
	<div class="sidebar_box">
		<div id="sidebar-menu">
			<ul class="metismenu" id="sidebar_menu">
				<li>
					<a href="<?php echo base_url() ?>wfm/dashboard/1">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/dashboard_left_menu.svg" class="sidebar_icon" alt="">
						<span>Dashboard</span>
					</a>
				</li>
				<li>
					<a href="#">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/user_left_menu.svg" class="sidebar_icon" alt="">
						<span>User</span>
						<span class="float-right arrow">
							<i class="fa fa-angle-down" aria-hidden="true"></i>
						</span>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url() ?>users/manage">
								<span>Manage</span>
							</a>
						</li>
						<?php if (is_access_add_user() == true) { ?>
							<li>
								<a href="<?php echo base_url() ?>users/chkuser">
									<span>Add</span>
								</a>
							</li>
						<?php } ?>
					</ul>
				</li>
				<!--				
				<li class="menu-item has-submenu">
					<a href="#" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Performance Evaluation</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">
						<li><a  href="<?php //echo base_url()
										?>evaluation">Own</a></li>
						<li><a  href="<?php //echo base_url()
										?>evaluation/evaluate_list">Review/Evaluate</a></li>
					</ul>
				</li>
				
												
				<li class="menu-item">
					<a href="<?php //echo base_url()
								?>logindetails" class="menu-link">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Update Login Details</span>
					</a>
				</li>
				-->
				<?php if (!is_access_cspl_my_team()) { ?>
					<li>
						<a href="<?php echo base_url() ?>querybrowser">
							<img src="<?php echo base_url(); ?>assets_home_v3/images/query_browser_left_menu.svg" class="sidebar_icon" alt="">
							<span>Query Browser</span>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="<?php echo base_url(); ?>assets_home_v3/images/schedule_left_menu.svg" class="sidebar_icon" alt="">
							<span>Schedule</span>
							<span class="float-right arrow">
								<i class="fa fa-angle-down" aria-hidden="true"></i>
							</span>
						</a>
						<ul class="submenu">
							<li>
								<a href="<?php echo base_url() ?>schedule">
									<span>Screen</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>schedule/upload_schedule">
									<span>Upload</span>
								</a>
							</li>
						</ul>
					</li>
				<?php } ?>
				<?php if (get_dept_folder() == "wfm" || get_global_access() || get_dept_folder() == "rta") { ?>
					<li>
						<a href="#">
							<img src="<?php echo base_url(); ?>assets_home_v3/images/report_left_menu.svg" class="sidebar_icon" alt="">
							<span>Schedule Report</span>
							<span class="float-right arrow">
								<i class="fa fa-angle-down" aria-hidden="true"></i>
							</span>
						</a>
						<ul class="submenu">
							<li>
								<a href="<?php echo base_url() ?>schedule/upload_report">
									<span>Upload Staus</span>
								</a>
							</li>
						</ul>
					</li>
				<?php } ?>
				<?php if (is_access_reset_password() == true) { ?>
					<li>
						<a href="<?php echo base_url() ?>user_password_reset">
							<img src="<?php echo base_url(); ?>assets_home_v3/images/password_reset_left_menu.svg" class="sidebar_icon" alt="">
							<span>Bulk Password Reset</span>
						</a>
					</li>
				<?php } ?>
				<?php if (is_access_l1_map() == true) { ?>
					<li>
						<a href="<?php echo base_url() ?>map_l1super">							
							<img src="<?php echo base_url(); ?>assets_home_v3/images/supervisor_left_menu.svg" class="sidebar_icon" alt="">
							<span>Map L1-Supervisor</span>
						</a>
					</li>
				<?php } ?>
				<!--
				
				<li>
					<a href="<?php echo base_url() ?>user_history/history">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Migrate User</span>
					</a>
				</li>
				
				-->
			</ul>			
		</div>
	</div>
</aside>