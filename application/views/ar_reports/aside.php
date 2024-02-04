<aside id="app-aside" class="app-aside left light">	
	<!--start new sidebar implementation-->
	<div class="sidebar_box">
		<div id="sidebar-menu">
			<ul class="metismenu" id="sidebar_menu">
				<li>
					<a href="<?php echo base_url() ?>ar_reports">
						<img src="<?php echo base_url();?>assets_home_v3/images/payroll	.svg" class="sidebar_icon" alt="">
						<span>Payroll</span>						
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() ?>ar_reports/attendance">
						<img src="<?php echo base_url();?>assets_home_v3/images/team_attendance_left.svg" class="sidebar_icon" alt="">
						<span>Attendance</span>
					</a>					
				</li>
				<?php if (get_role_dir() != "agent") { ?>
				<li>
					<a href="<?php echo base_url() ?>ar_reports/team_attendance">
						<img src="<?php echo base_url();?>assets_home_v3/images/team_attendance_left.svg" class="sidebar_icon" alt="">
						<span>Team Attendance</span>
					</a>
				</li>
				<?php } ?>
				<li>
					<a href="<?php echo base_url() ?>ar_reports/leave">
						<img src="<?php echo base_url();?>assets_home_v3/images/leave_left_menu.svg" class="sidebar_icon" alt="">
						<span>Leave</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() ?>ar_reports/login">
						<img src="<?php echo base_url();?>assets_home_v3/images/login_hours.svg" class="sidebar_icon" alt="">
						<span>Login hours</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() ?>ar_reports/leakage">
						<img src="<?php echo base_url();?>assets_home_v3/images/leakages.svg" class="sidebar_icon" alt="">
						<span>Leakages</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() ?>ar_reports/changelog">
						<img src="<?php echo base_url();?>assets_home_v3/images/changelog.svg" class="sidebar_icon" alt="">
						<span>Changelog</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() ?>ar_reports/rta_validation_report">
						<img src="<?php echo base_url();?>assets_home_v3/images/RTA_validate_report.svg" class="sidebar_icon" alt="">
						<span>RTA Validation Report</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<!--end new sidebar implementation-->

</aside>
<!--========== END app aside -->