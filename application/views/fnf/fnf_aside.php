<aside id="app-aside" class="app-aside left light">
	<div class="sidebar_box">
		<div id="sidebar-menu">
			<ul class="metismenu" id="sidebar_menu">
				<li>
					<a href="<?php echo base_url() ?>fnf">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/dashboard.svg" class="sidebar_icon" alt="">
						<span>FNF Dashboard</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() ?>fnf/completed">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/complete_left_menu.svg" class="sidebar_icon" alt="">
						<span>FNF Complete</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() ?>fnf/reports_archieve">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/report_archive_left_menu.svg" class="sidebar_icon" alt="">
						<span>Reports Archive</span>
					</a>
				</li>
				<?php if (get_global_access()) { ?>
					<li>
						<a href="<?php echo base_url() ?>fnf/fnf_notification_report">
							<img src="<?php echo base_url(); ?>assets_home_v3/images/report_left_menu.svg" class="sidebar_icon" alt="">
							<span>FNF Notification Report</span>
						</a>
					</li>
				<?php } ?>
				<li>
					<a href="<?php echo base_url() ?>fnf/user_fnf_assets_reports">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/performance.svg" class="sidebar_icon" alt="">
						<span>User FNF Assets Report</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</aside>