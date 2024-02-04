<aside id="app-aside" class="app-aside left light">
	<div class="sidebar_box">
		<div id="sidebar-menu">
			<ul class="metismenu" id="sidebar_menu">

				<?php if (it_assets_access() == true) { ?>

					<li>
						<a href="<?php echo base_url() ?>dfr_it_assets">
							<img src="<?php echo base_url(); ?>assets_home_v3/images/onboard_request.svg" class="sidebar_icon" alt="">
							<span class="">Onboarding Request</span>
						</a>
					</li>

				<?php } ?>

				<li>
					<a href="#">
						<img src="<?php echo base_url(); ?>assets_home_v3/images/assets_inventry_left_icon.svg" class="sidebar_icon" alt="">
						<span>Assets Inventory</span>
						<span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
					</a>
					<ul class="submenu">
						<?php if (get_dept_folder() == "it" || it_assets_access() == true) { ?>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/assets_stock_entry">
									<span>Inventory Dashboard</span>
								</a>
							</li>
						<?php } ?>
						<!--<li>
				<a href="<?php //echo base_url() ?>it_assets_support/amc_update_dashboard">					
					<span>AMC & Assets Support</span>
				</a>
			</li> -->
						<?php if (it_assets_access() == true) { ?>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/assets_movement">
									<span>Assets Movement</span>
								</a>
							</li>
						<?php }
						if (it_assets_full_access() == true) { ?>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/excel_import">
									<span>Excel Import</span>
								</a>
							</li>
						<?php } ?>
					</ul>
				</li>
				<?php if (it_assets_access() == true) { ?>
<!-- 					<li>
						<a href="#">
							<img src="<?php echo base_url(); ?>assets_home_v3/images/it_support_left_menu.svg" class="sidebar_icon" alt="">
							<span>IT Support</span>
							<span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
						</a>
						<ul class="submenu">
							<li>
								<a href="<?php echo base_url() ?>it_assets_support/it_support_dashboard">
									<span>Support Dashboard</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>it_assets_support/add_sop_assets_category">
									<span>Assets Issues List</span>
								</a>
							</li>
						</ul>
					</li> -->
				<?php } ?>

				<?php if (it_assets_full_access() == true) { ?>

					<li>
						<a href="#">
							<img src="<?php echo base_url(); ?>assets_home_v3/images/master.svg" class="sidebar_icon" alt="">
							<span>Master Entry</span>
							<span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
						</a>
						<ul class="submenu">
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/add_assets">
									<span>Assets Name</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/add_assets_brand">
									<span>Brand</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/add_vendor">
									<span>Vendor</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/add_ram">
									<span>RAM</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/add_storage">
									<span>Storage Device Size</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/add_phy_location">
									<span>Physical Location</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/add_assets_dept">
									<span>Processor</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/add_os">
									<span>OS</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/assets_company_brand_mst">
									<span>Company Brand</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/assets_user_assign_decline_mst">
									<span>User Assets Declined</span>
								</a>
							</li>

							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/config_inspection">
									<span>Configuration Inspection</span>
								</a>
							</li>

						</ul>
					</li>

				<?php }
				if (it_assets_access() == true) { ?>

					<li>
						<a href="#">
							<img src="<?php echo base_url(); ?>assets_home_v3/images/report_left_menu.svg" class="sidebar_icon" alt="">
							<span>Reports</span>
							<span class="float-right arrow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
						</a>
						<ul class="submenu">
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/user_assets_assignment_reports">
									<span>Assets Assignment Report (User)</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url() ?>dfr_it_assets/user_assets_report">
									<span class="">Assets Report</span>
								</a>
							</li>
							<!-- <li>
								<a href="<?php //echo base_url() ?>dfr_it_assets/mis_dashboard">
									<span>MIS Dashboard</span>
								</a>
							</li> -->
						</ul>						
					</li>
				<?php } ?>


			</ul>
		</div>
	</div>
</aside>

<script type="text/javascript">
	window.FontAwesomeConfig = {
		autoReplaceSvg: false
	}
</script>