<style>
a {
    text-decoration: none!important;
}
.aside-left-menu .submenu > li.category_menu > a{
	padding: 5px 5px 10px 30px!important;
}
.tabs-widget .nav-link {
	padding:10px 5px!important;
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
				<?php if(get_role_dir() != "agent" || get_global_access() || admin_access() || cns_l2_access()){ ?>
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-gear"></i></span>
						<span class="menu-text foldable">Master</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url()?>cns/master_type">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Type</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>cns/master_location">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Location</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>cns/location_access">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Location Access</span>
							</a>
						</li>
					</ul>
				</li>
				<?php } ?>				
				<li>					
					<a href="<?php echo base_url();?>cns/" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Set Date</span>
					</a>										
				</li>
				<!--<li>					
					<a href="<?php echo base_url();?>cns/set_notification" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Set Notification</span>
					</a>										
				</li>
				<li>					
					<a href="<?php echo base_url();?>cns/send_notification" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Send Notification</span>
					</a>										
				</li>-->
				<li>					
					<a href="<?php echo base_url();?>cns/cns_list" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">List</span>
					</a>										
				</li>
				<?php if(get_role_dir() != "agent" || get_global_access() || admin_access() || cns_l2_access()){ ?>	
				<li class="menu-item">					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="fa fa-gear"></i></span>
						<span class="menu-text foldable">Report</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>					
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url()?>cns/cns_report">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Report1</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>cns/report_breach">
								<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
								<span class="">Breach</span>
							</a>
						</li>
					</ul>
				</li>
				<li>					
					<a href="<?php echo base_url();?>cns/log_list" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Log</span>
					</a>										
				</li>
				<li>					
					<a href="<?php echo base_url();?>cns/cns_bulk_upload" class="menu-link">
						<span class="menu-icon"><i class="fa fa-bullseye"></i></span>
						<span class="menu-text foldable">Bulk Upload</span>
					</a>										
				</li>
				<?php } ?>							
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>