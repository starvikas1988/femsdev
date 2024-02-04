<!-- APP ASIDE ==========-->

<style>
.left-active a {
	background: #10c469!important;
	color: #fff!important;
	font-weight: bold!important;
}
</style>

<aside id="app-aside" class="app-aside left light">
	<header class="aside-header">
		<div class="animated">
			<a href="<?php echo base_url()?>home" id="app-brand" class="app-brand">
				<span id="brand-icon" class="brand-icon"></span>
				<span id="brand-name" class="brand-icon foldable"><img src="<?php echo base_url() ?>assets/images/fusion-bpo.png" border="0" alt="Fusion BPO"></span>
			</a>
		</div>
	</header><!-- #sidebar-header -->
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">

			<?php if(it_assets_access()==true){ ?>
				
				<li class="menu-item <?php if($activce_module == "dashboard") echo "left-active"; ?>">
					<a href="<?php echo base_url()?>dfr_it_assets" class="menu-link">
						<span class="menu-icon"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
						<span class="">Onboarding Request</span>
					</a>
				</li>

				<?php } ?>	

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-apps zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Assets Inventory</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">	
					<?php if(get_dept_folder() == "it" || it_assets_access()==true){ ?>					
						<li class="menu-item <?php if($activce_module == "stock_entry") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/assets_stock_entry" class="menu-link">
								<span class="menu-icon"><i class="fa fa-sticky-note" aria-hidden="true"></i></span>
								<span class="">Inventory Dashboard</span>
							</a>
						</li>
					<?php } ?>
<!-- 						<li class="menu-item <?php if($activce_module == "amc_update") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>it_assets_support/amc_update_dashboard" class="menu-link">
								<span class="menu-icon"><i class="fa fa-sticky-note" aria-hidden="true"></i></span>
								<span class="">AMC & Assets Support</span>
							</a>
						</li> -->
						<?php if(it_assets_access()==true){ ?>
						<li class="menu-item <?php if($activce_module == "assets_movement") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/assets_movement" class="menu-link">
								<span class="menu-icon"><i class="fa fa-sticky-note" aria-hidden="true"></i></span>
								<span class="">Assets Movement</span>
							</a>
						</li>
					<?php } if(it_assets_full_access()==true){ ?>											
						<li class="menu-item <?php if($activce_module == "import") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/excel_import" class="menu-link">
								<span class="menu-icon"><i class="fa fa-sticky-note" aria-hidden="true"></i></span>
								<span class="">Excel Import</span>
							</a>
						</li>
					<?php } ?>								
					</ul>
				</li>
				<?php if(it_assets_access()==true){ ?>
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-apps zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">IT Support</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">	
						<li class="menu-item <?php if($activce_module == "support_dashboard") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>it_assets_support/it_support_dashboard" class="menu-link">
								<span class="menu-icon"><i class="fa fa-sticky-note" aria-hidden="true"></i></span>
								<span class="">Support Dashboard</span>
							</a>
						</li>				
						<li class="menu-item <?php if($activce_module == "sop_category") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>it_assets_support/add_sop_assets_category" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">Assets Issues List</span>
							</a>
						</li>								
					</ul>
				</li>
				<?php } ?>	

			<?php if(it_assets_full_access()==true){ ?>

				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-apps zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Master Entry</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">						
						<li class="menu-item <?php if($activce_module == "add_assets") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/add_assets" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">Assets Name</span>
							</a>
						</li>
						<li class="menu-item <?php if($activce_module == "add_brand") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/add_assets_brand" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">Brand</span>
							</a>
						</li>	
						<li class="menu-item <?php if($activce_module == "add_vendor") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/add_vendor" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">Vendor</span>
							</a>
						</li>	
						<li class="menu-item <?php if($activce_module == "add_ram") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/add_ram" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">RAM</span>
							</a>
						</li>	
						<li class="menu-item <?php if($activce_module == "storage_ast") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/add_storage" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">Storage Device Size</span>
							</a>
						</li>						
						<li class="menu-item <?php if($activce_module == "location_phy") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/add_phy_location" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">Physical Location</span>
							</a>
						</li>
						<li class="menu-item <?php if($activce_module == "dpt_mst") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/add_assets_dept" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">Processor</span>
							</a>
						</li>
						<li class="menu-item <?php if($activce_module == "add_os") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/add_os" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">OS</span>
							</a>
						</li>
						<li class="menu-item <?php if($activce_module == "company_brand_mst") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/assets_company_brand_mst" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">Company Brand</span>
							</a>
						</li>
						<li class="menu-item <?php if($activce_module == "user_delined") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/assets_user_assign_decline_mst" class="menu-link">
								<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
								<span class="">User Assets Declined</span>
							</a>
						</li>

					</ul>
				</li>

			<?php } if(it_assets_access()==true){ ?>
				
				<li class="menu-item has-submenu">
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-bug" aria-hidden="true"></i></span>
						<span class="menu-text foldable">Reports</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					<ul class="submenu">						
						<li class="menu-item <?php if($activce_module == "user_assignment") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/user_assets_assignment_reports" class="menu-link">
								<span class="menu-icon"><i class="fa fa-sticky-note" aria-hidden="true"></i></span>
								<span class="">Assets Assignment Report</span>
							</a>
						</li>					
					</ul>
<!-- 					<ul class="submenu">						
						<li class="menu-item <?php if($activce_module == "import") echo "left-active"; ?>">
							<a href="<?php echo base_url()?>dfr_it_assets/mis_dashboard" class="menu-link">
								<span class="menu-icon"><i class="fa fa-sticky-note" aria-hidden="true"></i></span>
								<span class="">MIS Dashboard</span>
							</a>
						</li>					
					</ul>		 -->			
				</li>
				<?php } ?>			
				
				
				</ul>

		</nav>
			<!--end new menu accordian -->
				
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->

